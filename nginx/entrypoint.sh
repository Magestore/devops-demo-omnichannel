#!/bin/bash

# Run Nginx & Run ssh
nginx -g "daemon off;" & /etc/init.d/ssh start

