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
),
'clientsValid'=>array(

    
    array(
        'field' => 'name',
        'label' => 'Name',
        'rules' => 'required|trim|min_length[3]|max_length[50]|regex_match[/^[A-Za-z]+$/]',
        'errors' => [
            'required' => 'Name is required',
            'regex_match' => 'Only letters allowed (no spaces)'
        ]
    ),

    array(
        'field' => 'email',
        'label' => 'Email',
        'rules' => 'required|trim|valid_email|max_length[100]|is_unique[client.client_email]',
        'errors' => [
            'required' => 'Email is required',
            'valid_email' => 'Enter a valid email',
            'is_unique' =>'email_exists'
        ]
    ),

    array(
        'field' => 'phone',
        'label' => 'Phone',
        'rules' => 'required|trim|numeric|exact_length[10]',
        'errors' => [
            'required' => 'Phone is required',
            'exact_length' => 'Phone must be 10 digits'
        ]
    ),

    array(
        'field' => 'address',
        'label' => 'Address',
        'rules' => 'required|trim|min_length[10]|max_length[200]',
        'errors' => [
            'required' => 'Address is required'
        ]
    ),

   array(
    'field' => 'state',
    'label' => 'State',
    'rules' => 'required|trim|integer|greater_than[0]',
    'errors' => [
        'required' => 'State is required',
        'integer' => 'Invalid state selected',
        'greater_than' => 'Invalid state selected'
    ]
),

array(
    'field' => 'city',
    'label' => 'City',
    'rules' => 'required|trim|integer|greater_than[0]',
    'errors' => [
        'required' => 'City is required',
        'integer' => 'Invalid city selected',
        'greater_than' => 'Invalid city selected'
    ]
),

    array(
        'field' => 'pincode',
        'label' => 'Pincode',
        'rules' => 'required|trim|numeric|exact_length[6]',
        'errors' => [
            'required' => 'Pincode is required',
            'exact_length' => 'Pincode must be 6 digits'
        ]
    )


)


);
