import re
import sys
import locale
import numpy as np
import matplotlib.pyplot as plt
import matplotlib.dates as mdates
from matplotlib.backends.backend_pdf import PdfPages
from datetime import datetime
from ua_parser import user_agent_parser

# make sure the time format
locale.setlocale(locale.LC_ALL, 'en_US')

############### FUNCTION DEFINITION ###############

def load_access_log(file, user):
	# from Apache log file
	parts = [
			r'(?P<host>\S+)',                   # host %h
			r'\S+',                             # indent %l (unused)
			r'(?P<user>\S+)',                   # user %u
			r'\[(?P<time>.+)\]',                # time %t
			r'"(?P<request>.*)"',               # request "%r"
			r'(?P<status>[0-9]+)',              # status %>s
			r'(?P<size>\S+)',                   # size %b (careful, can be '-')
			r'"(?P<referrer>.*)"',              # referrer "%{Referer}i"
			r'"(?P<agent>.*)"',                 # user agent "%{User-agent}i"
	]
	pattern = re.compile(r'\s+'.join(parts)+r'\s*\Z')
	
	logdata = []
	for line in file:
		if user in line:
			logdata.append(pattern.match(line).groupdict())
			
	return logdata

def parse_access_log(logdata, predicate):
	
	flitered_data = []
	for line in logdata:
		if predicate(line['request']):
			flitered_data.append(line)
			
	dates = []
	description = []
	for data in flitered_data:
		dates.append(data['time'])
		browser_type = user_agent_parser.Parse(data["agent"])["user_agent"]["family"]
		description.append("Browser: %s\nHost %s\n%s" % (browser_type, data['host'], data['time']))
		
	dates = [datetime.strftime(d, "%d/%b/%Y:%H:%M:%S %z") for d in dates]
	
	return dates, description

def load_error_log(file):
	parts = [
		r'\[(?P<time>.*?)\]',              # time %t
		r'\[(?P<type>.*?)\]',              # type of error
		r'\[(?P<pid>.*?)\]',               # process id
		r'\[(?P<client>.*?)\]',            # client IP address
		r'(?P<description>.*)'             # error description (did not used)
	]
	pattern = re.compile(r'\s+'.join(parts)+r'\s*\Z')
	
	logdata = []
	for line in file:
		logdata.append(pattern.match(line).groupdict())
			
	return logdata

def parse_error_log(logdata):
	dates = []
	description = []
	for data in flitered_data:
		dates.append(data['time'])
		browser_type = user_agent_parser.Parse(data["agent"])["user_agent"]["family"]
		description.append("Browser: %s\nHost %s\n%s" % (browser_type, data['host'], data['time']))
		
	dates = [datetime.strftime(d, "%d/%b/%Y:%H:%M:%S %z") for d in dates]
	
	return dates, description

def timeline_dia(title, dates, descriptions, pdf):
	#https://matplotlib.org/3.1.3/gallery/lines_bars_and_markers/timeline.html

	levels = np.tile([-10, 10, -5, 5, -3, 3], int(np.ceil(len(dates)/6)))[:len(dates)]
	
	fig, ax = plt.subplots(figsize=(16, 8))
	ax.set(title=title)
		
	markerline, stemline, baseline = ax.stem(dates, levels,linefmt="C3-", basefmt="k-")
		
	plt.setp(markerline, mec="k", mfc="w", zorder=3)
		
	markerline.set_ydata(np.zeros(len(dates)))
		
	vert = np.array(['top', 'bottom'])[(levels > 0).astype(int)]
	for d, l, r, va in zip(dates, levels, descriptions, vert):
		ax.annotate(r, xy=(d, l), xytext=(-3, np.sign(l)*3),
			textcoords="offset points", va=va, ha="right", fontsize=5)
								
	ax.get_xaxis().set_major_locator(mdates.DayLocator(interval=1))
	ax.get_xaxis().set_major_formatter(mdates.DateFormatter("%d %b"))
	plt.setp(ax.get_xticklabels(), rotation=30, ha="right")
		
	ax.get_yaxis().set_visible(False)
	for spine in ["left", "top", "right"]:
		ax.spines[spine].set_visible(False)
			
	ax.margins(y=0.1)
	pdf.savefig(dpi=300)
		
	
	return None
	
############### FUNCTION DEFINITION ###############
####################### END #######################

with PdfPages("report.pdf") as pdf:
	access_log_file = open("/var/log/apache2/access_log", "r")
	
	logdata = load_access_log(access_log_file, "-")
	
	frequency_site_name = []
	frequency_site_count = []
	
	# Parse Log files for home.php
	dates, descriptions = parse_access_log(logdata, lambda line: "GET /index.php" in line )
	frequency_site_name.append("home.php")
	frequency_site_count.append(len(dates))
	timeline_dia("When and Who visited the home.php", dates, descriptions, pdf)
	
	# Parse Log files for imprint.php
	dates, descriptions = parse_access_log(logdata, lambda line: "GET /imprint.php" in line) 
	frequency_site_name.append("imprint.php")
	frequency_site_count.append(len(dates))
	timeline_dia("When and Who visited the imprint.php", dates, descriptions, pdf)
	
	
	# diagram for visits
	x_pos = [i for i, _ in enumerate(frequency_site_name)]
	
	plt.figure(figsize=(16, 8))
	plt.bar(x_pos, frequency_site_count)
	plt.xlabel("Pages")
	plt.ylabel("Count")
	plt.title("Frequnces of page visits")
	plt.xticks(x_pos, frequency_site_name)
	pdf.savefig(dpi=300)
	
	#diagram for error
	print("Parsing Error log")
	error_log_file = open("/var/log/apache2/error_log", "r")
	error_logdata = load_error_log(error_log_file)
	dates, descriptions = parse_error_log(error_logdata)
	
	create_time_line("Error Log TimeLine", dates, descriptions, pdf)