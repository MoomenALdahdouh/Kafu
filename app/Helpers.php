<?php


use App\Models\Company;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

function sendNotification($data)
{
    $notification = new Notification();
    $notification->title = $data["title"];
    $notification->message = $data["message"];
    $notification->description = $data["description"];
    $notification->model = $data["model"];
    $notification->model_id = $data["model_id"];
    $notification->path = $data["path"];
    $notification->sender = $data["sender"];
    $notification->receiver = $data["receiver"];
    $notification->status = $data["status"];
    $notification->type = $data["type"];
    $notification->sender_type = $data["sender_type"];
    $notification->created_at = Carbon::now();
    $notification->save();
}

function unreadNotificationsCount(){
    return auth()->user()->unreadNotifications->count();
}

function notifications(){
    return  auth()->user()->notifications;
}

function getNotifications($userId)
{
    return Notification::query()->where('receiver', $userId)->latest()->limit(10)->get();
}

function sendEmail($title, $name, $description_ar, $path, $send_to_id_fk, $receiver_email, $receiver_name, $model_fk_id, $sender_title, $sender_email, $sender_name)
{
    $data = [
        'recipient' => $receiver_email,
        'fromEmail' => "mmsss875@gmail.com",
        'fromName' => "Kafu",
        'sender_title' => $sender_title,
        'sender_email' => $sender_email,
        'sender_name' => $sender_name,
        'subject' => $title,
        'description' => $description_ar,
        'user_name' => $receiver_name,
        'name_ar' => $name,
        'path' => $path,
        'admin_id' => $send_to_id_fk,
        'model_fk_id' => $model_fk_id,
        'body' => $title, $name, $path, $receiver_email, $model_fk_id,
    ];
    Mail::send('admin.email.notification', $data, function ($message) use ($data) {
        $message->to($data['recipient'])
            ->from($data['fromEmail'], $data['fromName'])
            ->subject($data['subject']);
    });
}




function getUserPermissions()
{
    return auth('web')->user()->getPermissionsViaRoles()->pluck('name');
}

function getCompany()
{
    if (auth()->user()->can('company'))
        if (company())
            return company();
    return Company::query()->where('user_id', auth('web')->user()->id)->get()->first()->id;
}

function incubator()
{
    return auth('web')->user()->incubator;
}

function incubatorKey()
{
    return auth('web')->user()->can("incubator") ? incubator()->key : auth('web')->user()->company->incubator_key;
}

function company()
{
    return auth('web')->user()->company;
}

function incubator_key()
{
    $incubator_key = null;
    if (incubator())
        $incubator_key = incubator()->key;
    else
        $incubator_key = company()->incubator_key;
    return $incubator_key;
}

function companyId($company_id)
{
    if (!$company_id)
        $company_id = Company::query()->where('user_id', auth('web')->user()->id)->get()->first()->id;
    return $company_id;
}


function findCompany($id)
{
    $company = Company::query()->find($id);
    if (!$company)
        $company = Company::query()->where('user_id', auth('web')->user()->id)->get()->first();
    return $company;
}
