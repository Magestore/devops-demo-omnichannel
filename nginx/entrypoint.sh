#!/bin/bash

# Run ssh
/etc/init.d/ssh start & \
# Run Nginx
/usr/sbin/nginx
