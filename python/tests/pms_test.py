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

suite = unittest.TestLoader().loadTestsFromTestCase(TestPMSLib)
unittest.TextTestRunner(verbosity=2).run(suite)