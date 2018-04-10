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
	metric_id = model.getMetricId(report['metric_name'])
	if len(metric_id) != 0:
		status = model.insertAccuracy(metric_id['id'].values[0], report['ts_data'], report['report_message'])
	else:
		status = False
	return status

def insertTimelinessReport(report):
	metric_id = model.getMetricId(report['metric_name'])
	if len(metric_id) != 0:
		status = model.insertTimeliness(metric_id['id'].values[0], report['execution_time'])
	else:
		status = False
	return status

def insertErrorRateReport(report):
	metric_id = model.getMetricId(report['metric_name'])
	if len(metric_id) != 0:
		status = model.insertErrorRate(metric_id['id'].values[0], report['report_message'])
	else:
		status = False
	return status


# def deleteModule()


# def deleteMetric()


# def deleteReport()

