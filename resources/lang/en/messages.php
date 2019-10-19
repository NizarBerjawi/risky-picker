<?php return [
    'picker' => [
        'fail' => 'Could not find anyone to pick!',
        'success' => 'Awesome! Your order is on its way!',
    ],
    'user' => [
        'created'    => 'User successfully created.',
        'updated'    => 'User successfully updated.',
        'deleted'    => 'User successfully deleted.',
        'invited'    => 'User successfully invited.',
        'auth'       => 'You are not allowed to modify someone else\'s profile',
        'selfUpdate' => 'You are not allowed to modify you own profile',
    ],
    'cup' => [
        'created' => 'Cup successfully created.',
        'updated' => 'Cup successfully updated.',
        'deleted' => 'Cup successfully deleted.',
        'failed'  => 'Could not create cup.',
        'auth'    => 'You are not allowed to modify someone else\'s cup',
    ],
    'coffee' => [
        'created'   => 'Coffee successfully created.',
        'updated'   => 'Coffee successfully updated.',
        'deleted'   => 'Coffee successfully deleted.',
        'duplicate' => 'This coffee is already available',
        'invalid'   => 'The end time should be after the start time.',
        'conflict'  => 'Time range is already taken',
        'auth'      => 'You are not allowed to modify someone else\'s coffee',
    ],
    'run' => [
        'busy'      => 'We have sent a request for volunteers. You lazy ass.',
        'volunteer' => 'Thank you for taking this one.',
        'remove'    => 'Your coffee was removed from this coffee run successfully',
        'expired'   => 'This coffee run is not available any more.',
        'failed'    => 'Failed to select a new user for this coffee run.',
        'pick'      => 'Successfully selected a new user for this coffee run.',
        'auth'      => 'You are not allowed to remove someone else\'s coffee',
    ],
    'schedule' => [
        'created'  => 'Schedule successfully created.',
        'updated'  => 'Schedule successfully updated.',
        'deleted'  => 'Schedule successfully deleted',
        'conflict' => 'Time and day conflict',
    ]
];
