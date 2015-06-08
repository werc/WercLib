<?php
namespace WercLib;

return array(
    'service_manager' => array(
        'initializers' => array(
            'WercLib\Service\Initializer\Db',
            'WercLib\Service\Initializer\DbLanguage'
        )
    ),
    'view_helpers' => array(
        'invokables' => array(
            'rewrite' => 'WercLib\View\Helper\Rewrite',
            'renderBootstrapForm' => 'WercLib\View\Helper\RenderBootstrapForm',
            'zkratText' => 'WercLib\View\Helper\ZkratText',
            'fotogalerie' => 'WercLib\View\Helper\Fotogalerie',
            'shareLink' => 'WercLib\View\Helper\ShareLink',
            'routeLanguage' => 'WercLib\View\Helper\RouteLanguage',
            'attachments' => 'WercLib\View\Helper\Attachments',
        ),
        'factories' => array(
            'flashMessages' => 'WercLib\View\Helper\Factory\FlashMessagesFactory'
        )
    )
);

