# -*- coding: utf-8 -*-
import os,time,random
import requests
import sys

#reload(sys)
#sys.setdefaultencoding('utf8')
def req(url):
    print(url)
    try:
        response = requests.get(url)
        print(response.text)
    except requests.RequestException as e:
        print(e)

def reqall():
    host = "http://bosco.greatwallsolution.com"
    member = [
        '/api/cron/index'
    ]
    for each in member:
        req(host+each)
while True:
        reqall()
        time.sleep(1)
