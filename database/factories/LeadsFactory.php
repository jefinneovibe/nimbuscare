<?php

use Faker\Generator as Faker;
use MongoDB\BSON\ObjectID;
use Carbon\Carbon;
$autoIncrement = autoIncrement();

$factory->define(App\LeadDetails::class, function (Faker $faker) use ($autoIncrement) {
    $autoIncrement->next();
    $email = $faker->unique()->safeEmail;
    $phone = $faker->unique()->phoneNumber;
    $customer_object = new \stdClass();
    $customer_object->id = new ObjectID('5c0212636e3a921110352df4');
    $customer_object->name = 'Meenu Mohan';
    $customer_object->recipientName = 'Meenu Mohan';
    $customer_object->customerCode = '16';

    $agentObject = new \stdClass();
    $agentObject->id = new ObjectID('5be3f9beec47fb049233a798');
    $agentObject->name = 'Aiham Abdelky';

    $caseManagerObject = new \stdClass();
    $caseManagerObject->id = new ObjectID('5b321f4e2c7ad52a191fed43');
    $caseManagerObject->name = 'Admin';

    $deliveryObject = new \stdClass();
    $deliveryObject->id = new ObjectID('5b8f6d853607291437b56546');
    $deliveryObject->deliveryMode = 'Employee';

    $dispatchTypeObject = new \stdClass();
    $dispatchTypeObject->id = new ObjectID('5b8f6c05ebae6914373922c7');
    $dispatchTypeObject->dispatchType = 'Delivery & Collections';

    $emp_object = new \stdClass();
    $emp_object->id = new ObjectId('5be3f9beec47fb049233a798');
    $emp_object->name = 'Aiham Abdelky';
    $emp_object->empId = 'EP-0191';

    $Date = date('d/m/y');
    $splted_date = explode('/', $Date);
    $currentdate = implode($splted_date);
    date_default_timezone_set('Asia/Dubai');
    $time = date('His');
    $count = $autoIncrement->current();
    $newCount = $count + 1;
    if ($newCount < 10) {
        $newCount = '0' . $newCount;
    }
    $refNumber = "DC/" . $currentdate . "/" . $time . "/" . $newCount;

    $createdBy_obj = new \stdClass();
    $createdBy_obj->id = new ObjectID('5b321f4e2c7ad52a191fed43');
    $createdBy_obj->name = 'Admin';
    $createdBy_obj->date = date('d/m/Y');
    $createdBy_obj->action = "Lead Created";
    $createdBy[] = $createdBy_obj;

    $dispatchDetails = new \stdClass();
    $dispatchDetails->customer = $customer_object;
    $dispatchDetails->employee = $emp_object;

    $deliveryObject = new \stdClass();
    $deliveryObject->id = new ObjectID('5b8f6d153607291437b56544');
    $deliveryObject->deliveryMode = 'Agent';
    $dispatchDetails->deliveryMode = $deliveryObject;

    $disTypeObject = new \stdClass();
    $disTypeObject->id = new ObjectID('5b8f6c05ebae6914373922c7');
    $disTypeObject->dispatchType = 'Delivery & Collections';
    $dispatchDetails->taskType = $disTypeObject;
    $dispatchDetails->agent = 'Aiham Abdelky';
    $dispatchDetails->caseManager = 'Admin';
    $dispatchDetails->date_time = '03/12/2018 / 12:48 pm';
    $dispatchDetails->land_mark = 'Trivandrum';
    $dispatchDetails->address = 'KEECHERIYIL,RAMAPURAM PO,KOTTAYAM,ghghgSaint Paul';
    $dispatchDetails->emailId = $email;
    $dispatchDetails->contactNum = $phone;

    $doc_array = [];
    $doc_object = new \stdClass();
    $doc_object->documentId = new ObjectID('5b9669d7f48bc82d35c53d73');
    $doc_object->documentName = 'Policy document';
    $doc_object->amount = '';
    $doc_object->doc_collected_amount = 'NA';
    $doc_object->documentDescription = 'document';
    $doc_object->DocumentCurrentStatus = 18;
    $doc_object->documentTypeId = new ObjectID('5b8f6b693607291437b56543');
    $doc_object->documentType = 'Delivery';
    $uniqId = uniqid();
    $doc_object->id = $uniqId;
    $doc_object->status = (int)1;
    $doc_object->dispatchStatus = 'Delivery';
    $doc_object->gostatus = (int)1;
    $doc_array[] = $doc_object;

    $doc_object = new \stdClass();
    $doc_object->documentId = new ObjectID('5b966a43f48bc82d35c53d76');
    $doc_object->documentName = 'Cash';
    $doc_object->amount = '34534';
    $doc_object->doc_collected_amount = '';
    $doc_object->documentDescription = 'cash';
    $doc_object->DocumentCurrentStatus = 18;
    $doc_object->documentTypeId = new ObjectID('5b8f6b693607291437b56543');
    $doc_object->documentType = 'Delivery';
    $uniqId = uniqid();
    $doc_object->id = $uniqId;
    $doc_object->status = (int)1;
    $doc_object->dispatchStatus = 'Delivery';
    $doc_object->gostatus = (int)1;
    $doc_array[] = $doc_object;
    $dispatchDetails->documentDetails = $doc_array;
    $dispatchDetails->receivedBy = '';
    $dispatchDetails->deliveredBy = '';
    $dispatchDetails->active = (int)1;

    $updatedBy[] = $createdBy_obj;
    $updatedBy_obj = new \stdClass();
    $updatedBy_obj->id = new ObjectID('5b321f4e2c7ad52a191fed43');
    $updatedBy_obj->name = 'Admin';
    $updatedBy_obj->date = date('d/m/Y');
    $updatedBy_obj->action = "Reception";
    $updatedBy[] = $updatedBy_obj;
//    $updatedBy_obj = new \stdClass();
//    $updatedBy_obj->id = new ObjectID('5b321f4e2c7ad52a191fed43');
//    $updatedBy_obj->name = 'Admin';
//    $updatedBy_obj->date = date('d/m/Y');
//    $updatedBy_obj->action = "Delivery";
//    $updatedBy[] = $updatedBy_obj;

    $receptionStatusObject = new \stdClass();
    $receptionStatusObject->id = new ObjectID('5b321f4e2c7ad52a191fed43');
    $receptionStatusObject->name = 'Admin';
    $receptionStatusObject->date = date('d/m/Y');
    $receptionStatusObject->status = "Approved";
    $receStatus[] = $receptionStatusObject;

    $scheduleStatusObject = new \stdClass();
    $scheduleStatusObject->id = new ObjectID('5b321f4e2c7ad52a191fed43');
    $scheduleStatusObject->name = 'Admin';
    $scheduleStatusObject->date = date('d/m/Y');
    $scheduleStatusObject->status = "Approved";
    $ScheduleStatus[] = $scheduleStatusObject;

    $commentObject = new \stdClass();
    $commentObject->comment = 'Comment';
    $commentObject->commentBy = 'Admin';
    $commentObject->commentTime = '07:01:05';
    $commentObject->userType = "Admin";
    $commentObject->date = "04/01/2019";
    $comment[] = $commentObject;

    return [
        'customer' => $customer_object,
        'agent' => $agentObject,
        'caseManager' => $caseManagerObject,
        'deliveryMode' => $deliveryObject,
        'saveType' => 'customer',
        'dispatchType' => $dispatchTypeObject,
        'active' => (int)1,
        'contactNumber' => $phone,
        'contactEmail' => $email,
        'employee' => $emp_object,
        'referenceNumber' => (string)$refNumber,
        'createdBy' => $createdBy,
        'dispatchStatus' => 'Reception',
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'completedTabStatus' => 0,
        'deliveryTabStatus' => 0,
        'employeeTabStatus' => 0,
        'leadTabStatus' => 0,
        'receptionTabStatus' => 1,
        'scheduledTabStatus' => 0,
        'dispatchDetails' => $dispatchDetails,
        'updatedBy' => $updatedBy,
        'receptionistStatus' => $receStatus,
        'scheduleStatus' => $ScheduleStatus,
        'comments' => $comment
    ];
});

function autoIncrement()
{
    $Date = date('d/m/y');
    $splted_date = explode('/', $Date);
    $currentdate = implode($splted_date);
    $count = count(\App\LeadDetails::where('referenceNumber', 'like', '%' . $currentdate . '%')->get());
    for ($i = $count; $i < 5000; $i++) {
        yield $i;
    }
}
