<?php

namespace App\Observers;

use App\Models\ContactMessage;
use App\Services\LineBotService;

class ContactMessageObserver
{
    public function created(ContactMessage $message): void
    {
        $detail = filled($message->detail) ? $message->detail : '-';

        app(LineBotService::class)->pushMessage(
            "📋 ฟอร์มขอใบเสนอราคาใหม่\n".
            "รหัส: {$message->reference}\n".
            "ชื่อ: {$message->name}\n".
            "โทร: {$message->phone}\n".
            "บริการ: {$message->service}\n".
            "งบประมาณ: {$message->expected_budget}\n".
            "ส่วนลด E-Voucher: ".number_format($message->requested_discount)." บาท\n".
            "รายละเอียด: {$detail}\n".
            'เวลา: '.now()->format('Y-m-d H:i')
        );
    }
}
