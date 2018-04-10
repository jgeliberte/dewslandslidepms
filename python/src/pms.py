import pandas as pd
import pmsModel as model
import sys
import json
from StringIO import StringIO
from var_dump import var_dump

def insertModule(team_id, module_name, module_description):
	status = model.insertModule(team_id, module_name, module_description)
	return status

def insertMetric(module_id, metric_name, metric_description):
	status = model.insertMetric(module_id, metric_name, metric_description)
	return status

def insertTeam(team_name, team_description):
	status = model.insertTeam(team_name, team_description)
	return status

def insertAccuracyReport(report):
	metric = model.getMetric(report['metric_name'])
	if len(metric) != 0:
		status = model.insertAccuracy(metric['metric_id'].values[0], report['ts_data'], report['report_message'])
	else:
		status = False
	return status

def insertTimelinessReport(report):
	metric = model.getMetric(report['metric_name'])
	if len(metric) != 0:
		status = model.insertTimeliness(metric['metric_id'].values[0], report['execution_time'])
	else:
		status = False
	return status

def insertErrorRateReport(report):
	metric = model.getMetric(report['metric_name'])
	if len(metric) != 0:
		status = model.insertErrorRate(metric['metric_id'].values[0], report['report_message'])
	else:
		status = False
	return status

def getMetric(metric):
	metric = model.getMetric(metric['metric_name'], metric['limit'])
	return metric

def getModules(module):
	module = model.getModule(module['module_name'], module['limit'])
	return module

# def getDynaslopeTeams():

# def getAccuracyReport():

# def getErrorRateReport():
	
# def getTimelinessReport():

# def deleteModule()


# def deleteMetric()


# def deleteReport()