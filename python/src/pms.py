import pandas as pd
import pmsModel as model
import sys
import json
from StringIO import StringIO
from var_dump import var_dump

def insert_module(team_name, module_name, module_description):
	status = model.insertModule(team_name, module_name, module_description)
	return status

def insert_metric(module_name, metric_name, metric_description, metric_category):
	status = model.insertMetric(module_name, metric_name, metric_description, metric_category)
	return status

def insert_team(team_name, team_description):
	status = model.insertTeam(team_name, team_description)
	return status

def insert_accuracy_report(report):
	metric = model.getMetric(report['metric_name'])

	if len(metric) != 0:
		status = model.insertAccuracy(metric['metric_id'].values[0], report['ts_data'], report['report_message'])
	else:
		status = False
	return status

def insert_timeliness_report(report):
	metric = model.getMetric(report['metric_name'])

	if len(metric) != 0:
		status = model.insertTimeliness(metric['metric_id'].values[0], report['execution_time'])
	else:
		status = False
	return status

def insert_error_log_report(report):
	metric = model.getMetric(report['metric_name'])

	if len(metric) != 0:
		status = model.insertErrorRate(metric['metric_id'].values[0], report['report_message'])
	else:
		status = False
	return status

def get_metric(metric):
	metric = model.getMetric(metric['metric_name'], metric['limit'])
	return metric

def get_module(module):
	module = model.getModule(module['module_name'], module['limit'])
	return module

def get_teams(teams):
	teams = model.getTeams(teams['team_name'], teams['limit'])
	return teams

# def getAccuracyReport():
# def getErrorRateReport():
# def getTimelinessReport():
# def deleteModule()
# def deleteMetric()
# def deleteReport()