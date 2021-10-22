<?php declare( strict_types=1 );

namespace Leonid74\Helpers;

class UrlHelper
{
    public static function addTrailingSlash( string $path ): string
    {
        return \rtrim( $path, '/' ) . '/';
    }

    public static function removeTrailingSlash( string $path ): string
    {
        return \rtrim( $path, '/' );
    }

    public static function prependSlash( string $path ): string
    {
        return '/' . \ltrim( $path, '/' );
    }
}
