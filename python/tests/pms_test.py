import unittest
import sys
sys.path.append('../src')
import pms
import random

class TestPMSLib(unittest.TestCase):

    def test_insertNewTeam(self):
        status = pms.insertTeam('new_team_python'+str(random.randint(1, 99999)), 'new team descrsiption')
        self.assertTrue(status)

suite = unittest.TestLoader().loadTestsFromTestCase(TestPMSLib)
unittest.TextTestRunner(verbosity=2).run(suite)