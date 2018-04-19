# README for pms.js

Javascript Script File for Performance Monitoring System of Project Dynaslope - PHIVOLCS

## Getting Started

Include this Javascript file on header of development through http://<PMS Hostname>/js/pms.js

### Prerequisites

The following JS libraries are required to be loaded:

```
JQuery
Moment.js
```

## Deployment

The PMS JS has two objects:

```
PMS_MODAL
PMS
```

### PMS_MODAL

PMS_MODAL is an object used for displaying modal in order to get feedback/reports manually.
In order to create and utilize the modal, use its create function and save it in a variable.

```
const instance = PMS_MODAL.create(<object_of_parameters>);
``` 

There are several attributes you need to pass in the create function:

* metric_name - required
* module_name - required
* modal_id - defaults to "pms_modal"
* type - metric type; defaults to "accuracy"

A sample object of parameters to be passed:

```
const instance = PMS_MODAL.create({
    modal_id: `bulletin-accuracy-${release_id}`,
    metric_name: "bulletin_accuracy",
    module_name: "Bulletin",
    type: "accuracy"
});
```

Once created, the instance of PMS_MODAL will now have several functions:

* set() - sets value to important fields like `reference_id` and `reference_table`

```
instance.set({ reference_id: 1, reference_table: "smsinbox" });
```

* show() - use to show the created modal

* print() - echoes on console the data set along with other info to be sent on the server

```
instance.show();
instance.print();
```

### PMS

PMS is an object used for sending automatic reports on the database.
It only has one attribute function.

* send() - use to send reports on the database

```
PMS.send(<object_parameter>);
```

The function accepts an object parameter and automatically checks if required fields are filled up.
The following attributes are:

* type - metric type; (accuracy, error_logs, timeliness)
* metric_name
* module_name
* report_message
* reference_id - for accuracy type
* reference_table - for accuracy type
* execution_time - for timeliness type

If there are missing attributes, it will be printed on console.
