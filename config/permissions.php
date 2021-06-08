<?php

return [

    // TODO: in production replace all crc32 function with it's integer output (increases speed)
    'profiles' => [
        'can-follow'  => crc32('profile-can-follow'),
        'can-comment'  => crc32('profile-can-comment'),
        'can-view-posts'  => crc32('profile-can-view-posts'),
    ],
    'communities' => [
        'can-create-posts'                           => crc32('communities-can-create-posts'),
        'can-modify-own-posts'                       => crc32('communities-can-modify-own-posts'),
        'can-modify-members-posts'                   => crc32('communities-can-modify-members-posts'),
        'can-modify-admins-posts'                    => crc32('communities-can-modify-admins-posts'),
        'can-view-pending-member-joining-requests'   => crc32('communities-can-view-pending-member-joining-requests'),
        'can-comment-on-posts'                       => crc32('communities-can-comment-on-posts'),
        'can-reply-to-comments'                      => crc32('communities-can-reply-on-comments'),
        'can-like-comments'                          => crc32('communities-can-like-comments'),
        'can-like-posts'                             => crc32('communities-can-like-posts'),
        'can-mention-non-members'                    => crc32('communities-can-mention-non-members'),
        'can-mention-members'                        => crc32('communities-can-mention-members'),
        'can-attach-videos-to-own-post'              => crc32('communities-can-attach-videos-to-own-post'),
        'can-attach-videos-to-own-comment'           => crc32('communities-can-attach-videos-to-own-comment'),
        'can-attach-images-to-own-post'              => crc32('communities-can-attach-images-to-own-post'),
        'can-attach-images-to-own-comment'           => crc32('communities-can-attach-images-to-own-comment'),
        'can-remove-posts'                           => crc32('communities-can-remove-posts'),
        'can-remove-comments'                        => crc32('communities-can-remove-comments'),
        'can-mute-members'                           => crc32('communities-can-mute-members'),
        'can-kick-members'                           => crc32('communities-can-kick-members'),
        'can-ban-members'                            => crc32('communities-can-ban-members'),
        'can-temporarly-ban-members'                 => crc32('communities-can-temporarly-ban-members'),
        'can-share-verified-links'                   => crc32('communities-can-share-verified-links'),
        'can-share-unverified-links'                 => crc32('communities-can-share-unverified-links'),
    
        'can-modify-community-name'                  => crc32('communities-can-modify-community-name'),
        'can-modify-community-visibility'            => crc32('communities-can-modify-community-visibility'),
        'can-modify-community-description'           => crc32('communities-can-modify-community-description'),
    ]
];
