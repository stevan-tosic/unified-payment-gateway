#!/bin/bash

./reload-schema.sh

bin/console doctrine:fixtures:load -n --no-debug

bin/console cache:clear --env dev --no-warmup
bin/console cache:clear --env test --no-warmup
