import pandas as pd
import pmsModel as model
import sys
import json
from StringIO import StringIO

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

def getDynaslopeTeams(team):
	team = model.getTeam(team['team_name'], team['limit'])
	return team

def getAccuracyReport(report):
	report = model.getAccuracy(report['report_id'], report['limit'])
	return report

def getErrorRateReport(report):
	report = model.getErrorRate(report['report_id'], report['limit'])
	return report

def getTimelinessReport(report):
	report = model.getTimeliness(report['report_id'], report['limit'])
	return report

def updateMetric(metric):
	status = model.updateMetric(metric['metric_id'], metric['module_id'], metric['metric_name'], metric['description'])
	return status

def updateModule(module):
	status = model.updateModule(module['module_id'], module['team_id'], module['module_name'], module['description'])
	return status

def updateDynaslopeTeam(team):
	status = model.updateDynaslopeTeam(team['team_id'], team['team_name'], team['description'])
	return status

def updateAccuracyReport(report):
	status = model.updateAccuracy(report['report_id'], report['metric_id'], report['ts_received'], report['ts_data'], report['report_message'])
	return status

def updateErrorRateReport(report):
	status = model.updateErrorRate(report['report_id'], report['metric_id'], report['ts_received'], report['report_message'])
	return status

def updateTimelinessReport(report):
	status = model.updateTimeliness(report['report_id'], report['metric_id'], report['ts_received'], report['execution_time'])
	return status

def deleteModule(module_id):
	status = model.deleteModule(module_id)
	return status

def deleteMetric(metric_id):
	status = model.deleteMetric(metric_id)
	return status

def deleteDynaslopeTeam(team_id):
	status = model.deleteTeam(team_id)
	return status

def deleteAccuracyReport(report_id):
	status = model.deleteAccuracy(report_id)
	return status

def deleteErrorRateReport(report_id):
	status = model.deleteErrorRate(report_id)
	return status

def deleteTimelinessReport(report_id):
	status = model.deleteTimeliness(report_id)
	return status