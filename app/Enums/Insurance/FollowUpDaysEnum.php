<?php

namespace App\Enums\Insurance;

enum FollowUpDaysEnum: string
{
    case FURTHER_FOLLOW_UP = 'Further Follow-Up';
    case FOLLOW_UP_COMPLETE = 'Follow-Up Complete';
    case CALL_REQUIRED = 'Call Required';
    case SDP_PENDING = 'SDP Pending';
    case L2_PENDING = 'L2 Pending';
    case NV_PENDING = 'NV Pending';
    case TO_BE_REWORKED = 'To be Reworked';
    case TASK_TO_BE_CREATED = 'Task to be Created';
    case TASK_CREATED = 'Task Created';
    case CLAIM_CLOSED_IN_PMS = 'Claim Closed in PMS';
    case CLOSED_BY_QPS = 'Closed by QPS';
    case REBILLED = 'Rebilled';
    case APPEALED = 'Appealed';
    case MEDICAL_BILLING_REQUIRED = 'Medial Billing Required';
    case EOB_REQUESTED_FAX = 'EOB Requested - Fax';

    public function getDays(): int
    {
        return match ($this) {
            self::TASK_CREATED => 15,
            self::FURTHER_FOLLOW_UP => 15,
            self::REBILLED => 1,
            self::TO_BE_REWORKED => 1,
            self::TASK_TO_BE_CREATED => 1,
            self::SDP_PENDING => 1,
            self::NV_PENDING => 1,
            self::L2_PENDING => 1,
            self::CALL_REQUIRED => 1,
            self::EOB_REQUESTED_FAX => 1,
            default => 0,
        };
    }
}
