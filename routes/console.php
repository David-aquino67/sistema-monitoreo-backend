<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('check:server-status')->everyMinute();
