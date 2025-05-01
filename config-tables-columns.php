<?php

$tables_and_columns_names = array (
  'beneficiaries' => 
  array (
    'name' => '',
    'columns' => 
    array (
      'BeneficiaryID' => 
      array (
        'columndisplay' => 'BeneficiaryID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 1,
      ),
      'FullName' => 
      array (
        'columndisplay' => 'FullName',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'ContactInfo' => 
      array (
        'columndisplay' => 'ContactInfo',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'Address' => 
      array (
        'columndisplay' => 'Address',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'Description' => 
      array (
        'columndisplay' => 'Description',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'CreatedAt' => 
      array (
        'columndisplay' => 'CreatedAt',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
    ),
  ),
  'campaignbeneficiaries' => 
  array (
    'name' => '',
    'columns' => 
    array (
      'CampaignID' => 
      array (
        'columndisplay' => 'CampaignID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 1,
        'primary' => 1,
        'auto' => 0,
      ),
      'BeneficiaryID' => 
      array (
        'columndisplay' => 'BeneficiaryID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 1,
        'primary' => 1,
        'auto' => 0,
      ),
      'AllocationAmount' => 
      array (
        'columndisplay' => 'AllocationAmount',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
    ),
  ),
  'campaigns' => 
  array (
    'name' => '',
    'columns' => 
    array (
      'CampaignID' => 
      array (
        'columndisplay' => 'CampaignID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 1,
      ),
      'Name' => 
      array (
        'columndisplay' => 'Name',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'Description' => 
      array (
        'columndisplay' => 'Description',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'StartDate' => 
      array (
        'columndisplay' => 'StartDate',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'EndDate' => 
      array (
        'columndisplay' => 'EndDate',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'TargetAmount' => 
      array (
        'columndisplay' => 'TargetAmount',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'OrganizerID' => 
      array (
        'columndisplay' => 'OrganizerID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 1,
        'primary' => 1,
        'auto' => 0,
      ),
      'Status' => 
      array (
        'columndisplay' => 'Status',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'CreatedAt' => 
      array (
        'columndisplay' => 'CreatedAt',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
    ),
  ),
  'donations' => 
  array (
    'name' => '',
    'columns' => 
    array (
      'DonationID' => 
      array (
        'columndisplay' => 'DonationID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 1,
      ),
      'CampaignID' => 
      array (
        'columndisplay' => 'CampaignID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 1,
        'primary' => 1,
        'auto' => 0,
      ),
      'DonorID' => 
      array (
        'columndisplay' => 'DonorID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 1,
        'primary' => 1,
        'auto' => 0,
      ),
      'Amount' => 
      array (
        'columndisplay' => 'Amount',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'DonationDate' => 
      array (
        'columndisplay' => 'DonationDate',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
    ),
  ),
  'expenses' => 
  array (
    'name' => '',
    'columns' => 
    array (
      'ExpenseID' => 
      array (
        'columndisplay' => 'ExpenseID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 1,
      ),
      'CampaignID' => 
      array (
        'columndisplay' => 'CampaignID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 1,
        'primary' => 1,
        'auto' => 0,
      ),
      'Description' => 
      array (
        'columndisplay' => 'Description',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'Amount' => 
      array (
        'columndisplay' => 'Amount',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'ExpenseDate' => 
      array (
        'columndisplay' => 'ExpenseDate',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
    ),
  ),
  'users' => 
  array (
    'name' => '',
    'columns' => 
    array (
      'UserID' => 
      array (
        'columndisplay' => 'UserID',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 1,
      ),
      'FullName' => 
      array (
        'columndisplay' => 'FullName',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'Email' => 
      array (
        'columndisplay' => 'Email',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'PasswordHash' => 
      array (
        'columndisplay' => 'PasswordHash',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'Role' => 
      array (
        'columndisplay' => 'Role',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
      'CreatedAt' => 
      array (
        'columndisplay' => 'CreatedAt',
        'is_file' => 0,
        'columnvisible' => 1,
        'columninpreview' => 0,
        'fk' => 0,
        'primary' => 1,
        'auto' => 0,
      ),
    ),
  ),
);

?>