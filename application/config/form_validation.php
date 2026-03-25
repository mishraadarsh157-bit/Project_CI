<?php

$config = array(
    'usersValid' => array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|min_length[3]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|min_length[6]'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email|is_unique[users.email]',
            'errors' => array(
                'is_unique' => 'email_exists'

            )
        ),
        array(
            'field' => 'phone',
            'label' => 'Phone',
            'rules' => 'required|numeric|exact_length[10]'
        )
    ),
    'email' => array(
        array(
            'field' => 'emailaddress',
            'label' => 'EmailAddress',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|alpha'
        ),
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'required'
        ),
        array(
            'field' => 'message',
            'label' => 'MessageBody',
            'rules' => 'required'
        )
    ),
  'updateUser'=>array(
    array(
        'field' => 'name',
        'label' => 'Name',
        'rules' => 'required|min_length[3]|alpha_numeric_spaces'
    ),
    array(
        'field' => 'email',
        'label' => 'Email',
        'rules' => 'required|valid_email'
  ),
    array(
        'field' => 'phone',
        'label' => 'Phone',
        'rules' => 'required|numeric|exact_length[10]'
  )
));
