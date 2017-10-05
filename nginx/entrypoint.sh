#!/bin/bash

# Run ssh
/etc/init.d/ssh start & \
# Run Nginx
nginx -g daemon off
