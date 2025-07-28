#!/bin/bash

OPTIND=1
environment=$APP_ENV
while getopts "e:" opt; do
    case "$opt" in
    e)  environment=$OPTARG
        ;;
    esac
done

## Dev Environment
if [[ "$environment" != "test" ]]; then
    bin/console doctrine:database:drop --force

    bin/console doctrine:database:create
    bin/console doctrine:schema:create
fi

## Validate
bin/console doctrine:schema:validate
