#!/bin/bash

# Run Nginx & Run ssh
/etc/init.d/ssh start

nginx -g 'daemon off;'
