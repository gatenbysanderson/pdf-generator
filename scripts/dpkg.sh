#!/bin/bash

if ! type "prince" > /dev/null 2>&1; then
  (cd /) && (wget -O prince.deb http://www.princexml.com/download/prince_11.3-1_ubuntu16.04_amd64.deb)
  (dpkg -i prince.deb) && (rm -f prince.deb)
fi;
