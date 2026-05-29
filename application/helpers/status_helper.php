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
