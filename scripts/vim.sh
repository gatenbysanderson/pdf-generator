#!/bin/bash

(echo "syntax on\nset ai\nset number" > /root/.vimrc) && (cp /root/.vimrc /home/ubuntu/.vimrc)
