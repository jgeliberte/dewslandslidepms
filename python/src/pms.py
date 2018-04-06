import pmsModel as model

# def insertReport()


def insertModule(team_id, module_name, module_description):
	status = model.insertModule(team_id, module_name, module_description)
	return status

def insertMetric():
	status = model.insertMetric(module_id, metric_name, metric_description)
	return status

def insertTeam(team_name, team_description):
	status = model.insertTeam(team_name, team_description)
	return status

# def categorizeReport()


# def deleteModule()


# def deleteMetric()


# def deleteReport()

