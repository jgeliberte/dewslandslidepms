import unittest
import sys
sys.path.append('../src')
import pms
import random

class TestPMSLib(unittest.TestCase):

    def test_insertNewTeam(self):
        status = pms.insertTeam('new_team_python'+str(random.randint(1, 9999)), 'new team descrsiption test case No. 1')
        self.assertTrue(status)

    def test_insertModule(self):
        status = pms.insertModule(1,'new_module'+str(random.randint(1, 9999)), 'new module descrsiption test case No. 2')
        self.assertTrue(status)

    def test_insertMetric(self):
        status = pms.insertMetric(1,'new_metric'+str(random.randint(1, 9999)), 'new netric descrsiption test case No. 3')
        self.assertTrue(status)

    def test_insertAccuracyReport(self):
        report = {
            "metric_name":"new_metric89899",
            "ts_data":"2019-09-09 09:09:00",
            "report_message": "Report description for test No. 4"
        }

        status = pms.insertAccuracyReport(report)
        self.assertTrue(status)

    def test_insertErrorRateReport(self):
        report = {
            "metric_name":"new_metric89899",
            "report_message": "Report description for test No. 5"
        }

        status = pms.insertErrorRateReport(report)
        self.assertTrue(status)

    def test_insertTimelinessReport(self):
        report = {
            "metric_name":"new_metric89899",
            "execution_time": "100"
        }

        status = pms.insertTimelinessReport(report)
        self.assertTrue(status)

    def test_getMetric(self):
        metric = {
            "limit": "specific",
            "metric_name": "new_metric5206"
        }
        status = pms.getMetric(metric)
        self.assertEquals(len(status),1)

    def test_getAllMetrics(self):
        metric = {
            "limit": "all",
            "metric_name": ""
        }
        status = pms.getMetric(metric)
        if len(status) > 0:
            status = True
        else:
            status = False
        self.assertTrue(status)

    def test_getModules(self):
        module = {
            "limit": "specific",
            "module_name": "new_module7704"
        }
        status = pms.getModules(module)
        if len(status) > 0:
            status = True
        else:
            status = False
        self.assertTrue(status)
   
    def test_getDynaslopeTeam(self):
        module = {
            "limit": "specific",
            "team_name": "new_team_python630"
        }
        status = pms.getDynaslopeTeams(module)
        if len(status) > 0:
            status = True
        else:
            status = False
        self.assertTrue(status)

    def test_getAllDynaslopeTeams(self):
        module = {
            "limit": "all",
            "team_name": ""
        }
        status = pms.getDynaslopeTeams(module)
        if len(status) > 0:
            status = True
        else:
            status = False
        self.assertTrue(status)

    def test_getAccuracyReport(self):
        report = {
            "report_id": "5" ,
            "limit": "specific"
        }
        status = pms.getAccuracyReport(report)
        if len(status) > 0:
            status = True
        else:
            status = False
        self.assertTrue(status)

    def test_getAllAccuracyReport(self):
        report = {
            "report_id": "",
            "limit": "all"
        }
        status = pms.getAccuracyReport(report)
        if len(status) > 0:
            status = True
        else:
            status = False
        self.assertTrue(status)

    def test_getErrorRateReport(self):
        report = {
            "report_id": "5",
            "limit": "specific"
        }
        status = pms.getErrorRateReport(report)
        if len(status) > 0:
            status = True
        else:
            status = False
        self.assertTrue(status)

    def test_getAllErrorRateReport(self):
        report = {
            "report_id": "",
            "limit": "all"
        }
        status = pms.getErrorRateReport(report)
        if len(status) > 0:
            status = True
        else:
            status = False
        self.assertTrue(status)

    def test_getTimelinessReport(self):
        report = {
            "report_id": "5",
            "limit": "specific"
        }
        status = pms.getTimelinessReport(report)
        if len(status) > 0:
            status = True
        else:
            status = False
        self.assertTrue(status)

    def test_getAllTimelinessReport(self):
        report = {
            "report_id": "",
            "limit": "all"
        }
        status = pms.getTimelinessReport(report)
        if len(status) > 0:
            status = True
        else:
            status = False
        self.assertTrue(status)

    def test_updateMetric(self):
        metric = {
            "metric_id": "5",
            "module_id": "1",
            "metric_name": "Update Metric name"+str(random.randint(1, 9999)),
            "description": "Update Metric description"
        }
        status = pms.updateMetric(metric)
        self.assertTrue(status)

    def test_updateModule(self):
        module = {
            "module_id": "5",
            "team_id": "1",
            "module_name": "Updated Module name"+str(random.randint(1, 9999)),
            "description": "Updated Module description"
        }
        status = pms.updateModule(module)
        self.assertTrue(status)

    def test_updateDynaslopeTeam(self):
        team = {
            "team_id": "5",
            "team_name": "update_team"+str(random.randint(1, 9999)),
            "description": "Updated Team description"
        }
        status = pms.updateDynaslopeTeam(team)
        self.assertTrue(status)

    def test_updateAccuracyReport(self):
        report = {
            "report_id": "5",
            "metric_id": "2",
            "ts_received": "2019-04-12 13:20:00",
            "ts_data": "2029-09-09 09:09:00",
            "report_message": "Update Accuracy report for test case No. 21"
        }
        status = pms.updateAccuracyReport(report)
        self.assertTrue(status)

    def test_updateErrorRateReport(self):
        report = {
            "report_id": "5",
            "metric_id": "2",
            "ts_received": "2019-04-12 13:20:00" ,
            "report_message": "Update Error rate report for test case No. 22"
        }
        status = pms.updateErrorRateReport(report)
        self.assertTrue(status)

    def test_updateTimelinessReport(self):
        report = {
            "report_id": "5",
            "metric_id": "2",
            "ts_received": "2019-04-12 13:20:00",
            "execution_time": "23"
        }
        status = pms.updateTimelinessReport(report)
        self.assertTrue(status)

    def test_deleteMetric(self):

    def test_deleteModule(self):

    def test_deleteDynaslopeteam(self):

    def test_deleteAccuracyReport(self):

    def test_deleteErrorRateReport(self):

    def test_deleteTimelinessReport(self):


suite = unittest.TestLoader().loadTestsFromTestCase(TestPMSLib)
unittest.TextTestRunner(verbosity=2).run(suite)