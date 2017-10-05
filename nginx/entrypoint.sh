#!/bin/bash

# Run Nginx & Run ssh
service ssh start

nginx -g 'daemon off;'
