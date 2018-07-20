import unittest
import sys
sys.path.append('../src')
import pms
import random

class TestPMSLib(unittest.TestCase):

    # def test_insertNewTeam(self):
    #     status = pms.insert_team('new_team_python'+str(random.randint(1, 9999)), 'new team descrsiption test case No. 1')
    #     self.assertTrue(status)

    def test_insertModule(self):
        status = pms.insert_module('swat','new_module'+str(random.randint(1, 9999)), 'new module descrsiption test case No. 2')
        self.assertTrue(status)

    # def test_insertMetric(self):
    #     status = pms.insert_metric('chatterbox','new_metric'+str(random.randint(1, 9999)), 'new netric descrsiption test case No. 3')
    #     self.assertTrue(status)

    # def insert_accuracy_report(self):
    #     report = {
    #         "module_name": "chatterobx",
    #         "metric_name":"quick_search",
    #         "ts_data":"2019-09-09 09:09:00",
    #         "report_message": "Report description for test No. 4"
    #     }

    #     status = pms.insert_accuracy_report(report)
    #     self.assertTrue(status)

    # def insert_error_log_report(self):
    #     report = {
    #         "module_name": "chatterobx",
    #         "metric_name":"quick_search",
    #         "report_message": "Report description for test No. 5"
    #     }

    #     status = pms.insert_error_log_report(report)
    #     self.assertTrue(status)

    # def insert_timeliness_report(self):
    #     report = {
    #         "module_name": "chatterobx",
    #         "metric_name":"quick_search",
    #         "execution_time": "100"
    #     }

    #     status = pms.insert_timeliness_report(report)
    #     self.assertTrue(status)

    # def test_getMetric(self):
    #     metric = {
    #         "limit": "specific",
    #         "metric_name": "quick_search"
    #     }
    #     status = pms.get_metric(metric)
    #     self.assertEquals(len(status),1)

    # def test_getAllMetrics(self):
    #     metric = {
    #         "limit": "all",
    #         "metric_name": ""
    #     }
    #     status = pms.get_metric(metric)
    #     if len(status) > 0:
    #         status = True
    #     else:
    #         status = False
    #     self.assertTrue(status)

    # def test_getModules(self):
    #     module = {
    #         "limit": "specific",
    #         "module_name": "chatterbox"
    #     }
    #     status = pms.get_module(module)

suite = unittest.TestLoader().loadTestsFromTestCase(TestPMSLib)
unittest.TextTestRunner(verbosity=2).run(suite)