<?php

return [

    // TODO: in production replace all crc32 function with it's integer output (increases speed)

    'can-create-posts'                           => crc32('can-create-posts'),
    'can-modify-own-posts'                       => crc32('can-modify-own-posts'),
    'can-modify-members-posts'                   => crc32('can-modify-members-posts'),
    'can-modify-admins-posts'                    => crc32('can-modify-admins-posts'),
    'can-view-pending-member-joining-requests'   => crc32('can-view-pending-member-joining-requests'),
    'can-comment-on-posts'                       => crc32('can-comment-on-posts'),
    'can-comment-on-comments'                    => crc32('can-comment-on-comments'),
    'can-like-comments'                          => crc32('can-like-comments'),
    'can-like-posts'                             => crc32('can-like-posts'),
    'can-mention-non-members'                    => crc32('can-mention-non-members'),
    'can-mention-members'                        => crc32('can-mention-members'),
    'can-attach-videos-to-own-post'              => crc32('can-attach-videos-to-own-post'),
    'can-attach-videos-to-own-comment'           => crc32('can-attach-videos-to-own-comment'),
    'can-attach-images-to-own-post'              => crc32('can-attach-images-to-own-post'),
    'can-attach-images-to-own-comment'           => crc32('can-attach-images-to-own-comment'),
    'can-remove-posts'                           => crc32('can-remove-posts'),
    'can-remove-comments'                        => crc32('can-remove-comments'),
    'can-mute-members'                           => crc32('can-mute-members'),
    'can-kick-members'                           => crc32('can-kick-members'),
    'can-ban-members'                            => crc32('can-ban-members'),
    'can-temporarly-ban-members'                 => crc32('can-temporarly-ban-members'),
    'can-share-verified-links'                   => crc32('can-share-verified-links'),
    'can-share-unverified-links'                 => crc32('can-share-unverified-links'),

    'can-modify-community-name'                  => crc32('can-modify-community-name'),
    'can-modify-community-visibility'            => crc32('can-modify-community-visibility'),
    'can-modify-community-description'           => crc32('can-modify-community-description'),
];
