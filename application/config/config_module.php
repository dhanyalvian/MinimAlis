<?php
$config['module']['registration'] = array (
    'left' => array (
        'charging',
        array ('type' => 'textarea', 'name' => 'message', 'label' => 'Register Message')
    ),
    'right' => array (
        array ('type' => 'checkbox', 'name' => 'rereg_welcome', 'label' => 'Rereg Welcome'),
        array ('type' => 'textarea', 'name' => 'msg_isregistered', 'label' => 'Message Is Register')
    )
);
$config['module']['unregistration'] = array (
    'left' => array (
        'charging',
        array ('type' => 'textarea', 'name' => 'message', 'label' => 'Text Message')
    ),
    'right' => array (
        array ('type' => 'checkbox', 'name' => 'pull_member', 'label' => 'Pull Member'),
        array ('type' => 'textarea', 'name' => 'msg_unreg_notregistered', 'label' => 'Message Not Register')
    )
);
$config['module']['text'] = array (
    'left' => array (
        'charging',
        array ('type' => 'textarea', 'name' => 'message', 'label' => 'Message')
    ),
    'right' => array (
        array ('type' => 'checkbox', 'name' => 'rereg_content', 'label' => 'Rereg Content')
    )
);
$config['module']['textpull'] = array (
    'left' => array (
        'charging',
        array ('type' => 'textarea', 'name' => 'message', 'label' => 'Message')
    ),
    'right' => array (
        array ('type' => 'checkbox', 'name' => 'pull_member', 'label' => 'Pull Member'),
        array ('type' => 'textarea', 'name' => 'msg_pull_notregistered', 'label' => 'Message Pull Not Register')
    )
);
$config['module']['textdelay'] = array (
    'left' => array (
        'charging',
        array ('type' => 'textarea', 'name' => 'message', 'label' => 'Message')
    ),
    'right' => array (
        array ('type' => 'checkbox', 'name' => 'rereg_content', 'label' => 'Rereg Content')
    )
);
$config['module']['textdelaypull'] = array (
    'left' => array (
        'charging',
        array ('type' => 'textarea', 'name' => 'message', 'label' => 'Message')
    ),
    'right' => array (
        array ('type' => 'checkbox', 'name' => 'pull_member', 'label' => 'Pull Member'),
        array ('type' => 'textarea', 'name' => 'msg_pull_notregistered', 'label' => 'Message Pull Not Register')
    )
);
$config['module']['waplink'] = array (
    'left' => array (
        'charging',
        array ('type' => 'textarea', 'name' => 'message', 'label' => 'Message (@URL@)')
    ),
    'right' => array (
        array ('type' => 'checkbox', 'name' => 'rereg_content', 'label' => 'Rereg Content'),
        array ('type' => 'text', 'name' => 'wapdownload_name', 'label' => 'Wap Name'),
        array ('type' => 'text', 'name' => 'wapdownload_limit', 'label' => 'Download Limit', 'attributes' => array ('size' => 5))
    )
);
$config['module']['wappush'] = array (
    'left' => array (
        'charging',
        array ('type' => 'textarea', 'name' => 'message', 'label' => 'Message (@URL@)'),
        array ('type' => 'textarea', 'name' => 'msg_pull_notregistered', 'label' => 'Message Pull Not Register')
    ),
    'right' => array (
        array ('type' => 'checkbox', 'name' => 'pull_member', 'label' => 'Pull Member'),
        array ('type' => 'text', 'name' => 'wapdownload_name', 'label' => 'Wap Name'),
        array ('type' => 'text', 'name' => 'wapdownload_limit', 'label' => 'Download Limit', 'attributes' => array ('size' => 5))
    )
);
