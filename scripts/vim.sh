#!/bin/bash

(echo -e "syntax on\nset ai" > /root/.vimrc) && (cp /root/.vimrc /home/ubuntu/.vimrc)
