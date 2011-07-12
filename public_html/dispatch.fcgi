#!/usr/bin/env /usr/bin/perl
use strict;
use warnings;
use utf8;
use lib qw(
    ../extlib2
    ../extlib/lib/perl5 ../extlib/lib/perl5/x86_64-linux-gnu-thread-multi
);
use AnyEvent;
use Plack::Handler::AnyEvent::FCGI;

my $app = sub {
    my $env = shift;

    return sub {
        my $respond = shift;
        my $t; $t = AE::timer 0, 0, sub {
            $respond->([
                200, ["Content-Type" => "text/plain; charset=utf-8"], ["OK\n"]
            ]);
            undef $t;
        };
    };
};

Plack::Handler::AnyEvent::FCGI->new(
    listen => [":8888"], # dummy port
)->run($app);
