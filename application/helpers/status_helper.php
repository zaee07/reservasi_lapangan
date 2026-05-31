<?php

function badge_status_slot($status)
{
    switch ($status) {

        case STATUS_SLOT_AVAILABLE:
            return '<span class="badge bg-label-success">Tersedia</span>';

        case STATUS_SLOT_BOOKED:
            return '<span class="badge bg-label-primary">Dipesan</span>';

        case STATUS_SLOT_IN_USED:
            return '<span class="badge bg-label-warning">Sedang dipakai</span>';

        case STATUS_SLOT_CLOSED:
            return '<span class="badge bg-label-danger">Maintenance/Tutup</span>';

        default:
            return '<span class="badge bg-label-secondary">Unknown</span>';
    }
}

function badge_status_booking($status)
{
    switch ($status) {

        case STATUS_BOOKING_PENDING:

            return '
            <span class="badge bg-warning">
                Pending
            </span>';

        case STATUS_BOOKING_CONFIRMED:

            return '
            <span class="badge bg-success">
                Confirmed
            </span>';

        case STATUS_BOOKING_CHECKIN:

            return '
            <span class="badge bg-primary">
                Checked In
            </span>';

        case STATUS_BOOKING_COMPLETED:

            return '
            <span class="badge bg-dark">
                Completed
            </span>';

        case STATUS_BOOKING_CANCELLED:

            return '
            <span class="badge bg-danger">
                Cancelled
            </span>';

        case STATUS_BOOKING_EXPIRED:

            return '
            <span class="badge bg-secondary">
                Expired
            </span>';

        default:

            return '
            <span class="badge bg-light text-dark">
                Unknown
            </span>';
    }
}
function badge_status_pembayaran($status)
{
    switch ($status) {

        case 'paid':

            return '
        <span class="badge bg-success">
            Paid
        </span>';

        case 'unpaid':

            return '
        <span class="badge bg-warning">
            Pending
        </span>';

        case 'expired':

            return '
        <span class="badge bg-secondary">
            Expired
        </span>';

        case 'failed':

            return '
        <span class="badge bg-danger">
            Failed
        </span>';

        default:

            return '
        <span class="badge bg-dark">
            Unpaid
        </span>';
    }
}
