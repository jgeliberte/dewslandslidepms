import unittest
import sys
sys.path.append('../src')
import pms
import random

class TestPMSLib(unittest.TestCase):

    def test_insertNewTeam(self):
        status = pms.insertTeam('new_team_python'+str(random.randint(1, 99999)), 'new team descrsiption test case No. 1')
        self.assertTrue(status)

    def test_insertModule(self):
        status = pms.insertModule(1,'new_module'+str(random.randint(1, 99999)), 'new module descrsiption test case No. 2')
        self.assertTrue(status)

    def test_insertMetric(self):
        status = pms.insertModule(1,'new_metric'+str(random.randint(1, 99999)), 'new netric descrsiption test case No. 3')
        self.assertTrue(status)

suite = unittest.TestLoader().loadTestsFromTestCase(TestPMSLib)
unittest.TextTestRunner(verbosity=2).run(suite)