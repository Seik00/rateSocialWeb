#!/usr/bin/python
# coding=UTF-8
import sys
import random
import math
import time
import os
import requests
import configparser
import subprocess
import MySQLdb
import json
import _thread
import uuid
import urllib.request
from urllib.parse import urlencode
import ccxt

thread_alive = {}
pending_order = {}
all_ticker = {}
platform_ticker_time = {}

def get_conf(name):
    cp = configparser.ConfigParser()
    the_dir = sys.path[0]
    # print(the_dir)
    cp.read(the_dir+'/db.conf')
    return cp.get('db', name)


def Conn():
    cp = configparser.ConfigParser()
    the_dir = sys.path[0]
    print(the_dir)
    cp.read(the_dir+'/db.conf')
    return MySQLdb.connect(host=cp.get('db', 'host'), user=cp.get('db', 'user'), passwd=cp.get('db', 'pass'), db=cp.get('db', 'name'), port=int(cp.get('db', 'port')), charset=cp.get('db', 'charset'))
    # return MySQLdb.connect(host='127.0.0.1',user='root',passwd='root',db='testdb',port=3306, charset="utf8")

def getAllTick(platform):
    if platform in platform_ticker_time:
        last_time = platform_ticker_time[platform]
        now_time =  int(time.time())
        if now_time- last_time < 2:
            print('fetch', platform, 'ticker pass , wait next time')
            return
    exchange_id = platform
    if exchange_id == 'huobi':
        exchange_id = 'huobipro'
    exchange_class = getattr(ccxt, exchange_id)
    exchange = exchange_class({
        #'apiKey': api_key,
        #'secret': secret_key,
        #'password': passphrase,        
        'timeout': 30000,
        'enableRateLimit': True,
    })
    try:
        #print('fetch', platform, 'ticker : ', market)
        #ticker_data = exchange.fetch_ticker(market)
        print('fetch', platform, 'ticker')
        ticker_data = exchange.fetch_tickers()     
        #print(ticker_data)
        if isinstance(ticker_data,dict):
            for ticker_item in ticker_data:
                #print(ticker_item)
                #print(ticker_data[ticker_item]['last'])
                if platform not in all_ticker:
                    all_ticker[platform] = {}
                all_ticker[platform][ticker_item] = ticker_data[ticker_item]
            platform_ticker_time[platform] = int(time.time())
        else:
            print('here i am')
            print(ticker_data)
    except Exception as e:
        print(e)
        return None    
        
def getTick(platform, api_info, market):
    getAllTick(platform)
    #print(all_ticker[platform])
    try:
        print('fetch', platform, 'ticker : ', market)
        if platform in all_ticker:
            if market in all_ticker[platform]:
                print(platform, ' ', market, ' price:', all_ticker[platform][market]['last'])
                return all_ticker[platform][market]['last']
        else:
            #print(all_ticker)
            print('fetch', platform, 'ticker ', market,': error')
            return None
    except Exception as e:
        print(e)
        return None

# jinglan tick
def getLocalTick(params):
    host = 'http://' + get_conf('corehost') + ':8080'
    headers = {'Content-Type': 'application/json', 'Connection': 'close'}
    post_data = {"id": 22, "method": "market.last", "params": params}
    encode_json = json.dumps(post_data)
    # print encode_json
    try:
        P_post = requests.post(host, headers=headers,
                               data=encode_json, timeout=5)
        if P_post.status_code == 200:
            rst = json.loads(P_post.text)
            # print rst
            if 'result' in rst:
                return rst['result']
            else:
                return None
        else:
            return None
    except Exception as e:
        print(e)
        return None

# 市价
def order(robot_id,side, api_info, market, amount):
    ret = {}
    #print(pending_order)
    if robot_id in pending_order:
        if pending_order[robot_id] == 1:
            ret['code'] = 0
            ret['data'] = {}
            ret['msg'] = 'wait pending order,robot:'+str(robot_id)
            #print(pending_order)
            return ret
        else:
            pending_order[robot_id] = 1
    else:
        pending_order[robot_id] = 1
    
    platform = api_info['platform']
    api_key = api_info['api_key']
    secret_key = api_info['secret_key']
    passphrase = api_info['passphrase']
    exchange_id = platform
    if exchange_id == 'huobi':
        exchange_id = 'huobipro'    
    exchange_class = getattr(ccxt, exchange_id)
    exchange = exchange_class({
        'apiKey': api_key,
        'secret': secret_key,
        'password': passphrase,
        'timeout': 30000,
        'enableRateLimit': True,
        'options': {
            'createMarketBuyOrderRequiresPrice': False,
        },
    })
    # if platform == 'okex':
    #     exchange.hostname = 'okexcn.com'
    #     exchange.urls['api']['rest'] = 'https://www.okexcn.com'
    # if platform == 'binance':
    #     exchange.urls['api']['v1'] = 'https://api.binancezh.cc/api/v1'
    #     exchange.urls['api']['v3'] = 'https://api.binancezh.cc/api/v3'
    #     exchange.urls['api']['private'] = 'https://api.binancezh.cc/api/v3'
    #     exchange.urls['api']['public'] = 'https://api.binancezh.cc/api/v3'
    try:
        # 卖
        if side == 1:
            result = exchange.create_market_sell_order(market, amount)
        else:
            # 买入
            print('--buy in---')
            print(market)
            print(amount)
            result = exchange.create_market_buy_order(
                market, amount, {'quoteOrderQty': amount})
            print(exchange)     
        print('--buy in result---')

        print(result)
        print('--buy end---')
        # deal_result = exchange.fetch_order('199284377498128')
        # print(deal_result)
        # return;
        order_info = {}
        order_info['order_id'] = result['id']
        if platform == 'okex':
            deal_result = exchange.fetch_order_trades(result['id'], market)
            print(deal_result)
            while len(deal_result) == 0:
                time.sleep(0.5)
                deal_result = exchange.fetch_order_trades(result['id'], market)
                print('robot detail')
                print(deal_result)
            order_info['deal_money'] = deal_result[0]['cost']
            order_info['deal_stock'] = deal_result[0]['amount']
            order_info['deal_fee'] = deal_result[0]['fee']['cost']
        elif platform == 'huobi':
            deal_result = exchange.fetch_order(result['id'])
            print('------deal result------')
            print(deal_result)
            print('------deal result end------')
            while len(deal_result) == 0:
                time.sleep(0.5)
                deal_result = exchange.fetch_order(result['id'])
                print('------deal fetch result------')
                print(deal_result)
                print('------deal fetch result end------')
            order_info['deal_money'] = deal_result['cost']
            order_info['deal_stock'] = deal_result['info']['field-amount']
            order_info['deal_fee'] = deal_result['fee']['cost']
        else:
            order_info['deal_money'] = result['cost']
            order_info['deal_stock'] = result['amount']
            order_info['deal_fee'] = result['fee']['cost']
        ret['code'] = 1
        ret['data'] = order_info
        ret['msg'] = 'success'
        pending_order[robot_id] = 0
        return ret
    except Exception as e:
        print(e)
        ret['code'] = 0
        ret['data'] = {}
        ret['msg'] = str(e)
        pending_order[robot_id] = 0
        return ret

# jinlan市价交易
def localOrder(side, token, market, amount):
    ret = {}
    try:
        textmod = {"access_token": token, "type": 2, "market": str(
            market), "side": side, "amount": str(amount), "pride": 0}
        textmod = urlencode(textmod)
        url = 'https://' + get_conf('domain') + '/api/exchange/order-limit'
        req = urllib.request.Request(url, textmod.encode())
        opener = urllib.request.urlopen(req)
        res = json.loads(opener.read().decode())
        order_info = {}
        if 'code' in res and res['code'] == 200:
            order_result = res['data']
            order_info['order_id'] = order_result['id']
            order_info['deal_money'] = order_result['deal_money']
            order_info['deal_stock'] = order_result['deal_stock']
            order_info['deal_fee'] = order_result['deal_fee']
            ret['code'] = 1
            ret['data'] = order_info
            ret['msg'] = 'success'
        else:
            ret['code'] = 0
            ret['data'] = {}
            ret['msg'] = res['message']
        print('===========jinlan市价交易============')
        print(ret)
        return ret
    except Exception as e:
        ret['code'] = 0
        ret['data'] = {}
        ret['msg'] = str(e)
        return ret

def updateMsg(robot_id, show_msg, show_msg_en):
    conn = Conn()
    cur = conn.cursor()
    update_sql = "update jl_quant_robot set show_msg = '%s' , show_msg_en = '%s' where id = %d" % (
        show_msg, show_msg_en, robot_id)
    print(update_sql)
    cur.execute(update_sql)
    conn.commit()
    cur.close()
    conn.close()


def updateValues(robot_id, values_str):
    conn = Conn()
    cur = conn.cursor()
    update_sql = "update jl_quant_robot set values_str = '%s' where id = %d" % (
        values_str, robot_id)
    print(update_sql)
    cur.execute(update_sql)
    conn.commit()
    cur.close()
    conn.close()


def updateRevenue(robot_id, revenue):
    conn = Conn()
    cur = conn.cursor()
    update_sql = "update jl_quant_robot set revenue = '%s' where id = %d" % (
        revenue, robot_id)
    print(update_sql)
    cur.execute(update_sql)
    conn.commit()
    cur.close()
    conn.close()


def disableRobot(robot_id):
    conn = Conn()
    cur = conn.cursor()
    update_sql = "update jl_quant_robot set status = 0 where id = %d" % robot_id
    print(update_sql)
    cur.execute(update_sql)
    conn.commit()
    cur.close()
    conn.close()


def cleanFinish(robot_id):
    conn = Conn()
    cur = conn.cursor()
    update_sql = "update jl_quant_robot set is_clean = 0 where id = %d" % robot_id
    print(update_sql)
    cur.execute(update_sql)
    conn.commit()
    cur.close()
    conn.close()


def insertLog(platform, robot_id, uid, log,content_log):
    conn = Conn()
    cur = conn.cursor(MySQLdb.cursors.DictCursor)
    cur.execute(
        "select id,content from jl_quant_robot_log where qrobot_id = %d order by id desc limit 0,1" % robot_id)
    last_log = cur.fetchone()
    if last_log:
        if last_log['content'] == log:
            return
    insert_sql = "insert jl_quant_robot_log(platform,uid,qrobot_id,content,content_log) values ('%s',%d,%d,'%s','%s')" % (
        platform, uid, robot_id, log, content_log)
    print(insert_sql)
    cur.execute(insert_sql)
    conn.commit()
    cur.close()
    conn.close()


def insertRevenueLog(platform, robot_id, pid, uid, market, stock, money, revenue):
    conn = Conn()
    cur = conn.cursor()
    insert_sql = "insert jl_quant_robot_revenue(platform,qrobot_id,pid,uid,market,stock,money,revenue,deal_recycle_status) values ('%s',%d,'%s',%d,'%s','%s','%s','%s',%d)" % (platform,
                                                                                                                                                                       robot_id, pid, uid, market, stock, money, revenue, 0)
    print(insert_sql)
    cur.execute(insert_sql)
    conn.commit()
    cur.close()
    conn.close()


def insertOrder(platform, uid, order_id, robot_id, side, market, stock, money, deal_money, deal_amount, price, is_first, uuid):
    conn = Conn()
    cur = conn.cursor()
    insert_sql = "insert jl_quant_robot_order(platform,uid,qrobot_id,side,market,stock,money,deal_money,deal_amount,price,order_status,is_first,pid) values ('%s',%d,%d,%d,'%s','%s','%s','%s','%s','%s',1,%d,'%s')" % (
        platform, uid, robot_id, side, market, stock, money, deal_money, deal_amount, price, is_first, uuid)
    print(insert_sql)
    cur.execute(insert_sql)
    conn.commit()

def getRobotConfig(robot_id):
    conn = Conn()
    cur = conn.cursor(MySQLdb.cursors.DictCursor)
    cur.execute("SELECT * from jl_quant_robot where status = 1 and id = %d" % robot_id)
    robot = cur.fetchone()
    return robot

# 策略主函数
def onTick(robot_id, market_info, api_info):
    robot_config = getRobotConfig(robot_id) 
    if not robot_config:
        print('------robot is empty-------')
        return
    if robot_config is  None:
        print('------robot is none-------')        
        return
    print('------onTick-------')
    market = market_info['market_name']
    stock_name = market_info['stock']
    money_name = market_info['money']
    market_type = market_info['type']
    robot_id = robot_config['id']
    platform = robot_config['platform']
    uid = robot_config['uid']
    is_clean = int(robot_config['is_clean'])
    # print(market)
    #check thread
    print(thread_alive)
    if robot_id in thread_alive:
        if thread_alive[robot_id] == 1:
            print('wait pending thread,robot:'+str(robot_id))
            return
        else:
            thread_alive[robot_id] = 1
    else:
        thread_alive[robot_id] = 1   
    
    if platform == 'sinance':
       param = [market_info['market']]
       tick_price = float(getLocalTick(param))
    else:
        tick_price = float(getTick(platform, api_info, market))

    print('tick_price',tick_price)
    if tick_price is None:
        thread_alive[robot_id] = 0
        return
        
    first_order_value = float(robot_config['first_order_value'])
    max_order_count = int(robot_config['max_order_count'])
    stop_profit_rate = float(robot_config['stop_profit_rate'])
    stop_profit_callback_rate = float(
        robot_config['stop_profit_callback_rate'])
    cover_rate = float(robot_config['cover_rate'])
    cover_callback_rate = float(robot_config['cover_callback_rate'])
    values_str = robot_config['values_str']
    recycle_status = int(robot_config['recycle_status'])
    if values_str:
        values_dict = json.loads(values_str)
        
        revenue = float(values_dict['deal_amount']) * \
            tick_price - float(values_dict['deal_money'])
        updateRevenue(robot_id, revenue)
        base_price = float(values_dict['base_price'])
        up_price = float(values_dict['up_price'])
        down_price = float(values_dict['down_price'])
        trend_side = int(values_dict['trend_side'])
        order_count =float(values_dict['order_count'])
        
        # 清仓卖出
        if is_clean == 1:
            insertLog(platform, robot_id, uid,
                      u"收到清仓卖出指令 ,当前价格 %s" % tick_price,
                      u"Receive clear order ,Current Price %s" % tick_price)
            if platform == 'sinance':
                token = api_info['secret_key']
                rst = localOrder(1, token, market_info['market'], values_dict['deal_amount'])
            else:
                rst = order(robot_id,1, api_info, market,
                            values_dict['deal_amount'])
            print('----------------clean order ================') 
            print(values_dict)          
            print(rst)
            print('----------------clean order end================')
            if rst['code'] == 1:
                cleanFinish(robot_id)
                order_id = rst['data']['order_id']
                deal_money = rst['data']['deal_money']
                deal_amount = rst['data']['deal_stock']
                deal_fee = rst['data']['deal_fee']
                price = float(deal_money)/float(deal_amount)
                side = 1
                deal_money = float(deal_money)-float(deal_fee)
                insertOrder(platform, uid, order_id, robot_id, side, market, stock_name,
                            money_name, deal_money, deal_amount, price, 2, values_dict['pid'])
                revenue = float(deal_money) - \
                    float(values_dict['deal_money'])
                print('----------------revenue ================')               
                print(revenue)
                print('---------------- revenue end================')
                insertRevenueLog(
                    platform, robot_id, values_dict['pid'], uid, market, stock_name, money_name, revenue)
                updateValues(robot_id, '')
                updateRevenue(robot_id, 0)
                updateMsg(robot_id, u'清仓卖出成功', u'Successful clearance')
                insertLog(platform, robot_id, uid, u"清仓卖出：成交总价 %s %s ,成交均价 %s %s,成交数量 %s %s" % (
                    deal_money, money_name, price, money_name, deal_amount, stock_name), u"Clearance sale: total transaction price %s %s ,average price %s %s,deal amount %s %s" % (
                    deal_money, money_name, price, money_name, deal_amount, stock_name))
                if recycle_status == 0:
                    # 关闭机器人
                    disableRobot(robot_id)
                    insertLog(platform, robot_id,
                              uid, u"量化机器人已经关闭", u"Robot shut down")
                else:
                    insertLog(platform, robot_id,
                              uid, u"量化机器人已经重新开启", u"Robot restart")
                thread_alive[robot_id] = 0
                return
            else:
                updateMsg(robot_id, u'清仓卖出失败' + rst['msg'])
                insertLog(platform, robot_id, uid,
                          u'清仓卖出失败' + rst['msg'], u"Clearance fail " + rst['msg'])
                thread_alive[robot_id] = 0
                return
        # 判断趋势
        if tick_price > base_price:
            print('trend_side',trend_side)
            if trend_side == 0 or trend_side == 2:
                up_num = tick_price - base_price
                up_rate = up_num * 100/base_price
                if up_rate >= stop_profit_rate:
                    # 上涨到止盈率
                    values_dict['trend_side'] = 1
                    values_dict['up_price'] = tick_price
                    updateValues(robot_id, json.dumps(values_dict))
                    insertLog(platform, robot_id, uid, u"达到止盈率 %s ,当前上涨价格 %s" %
                              (up_rate, tick_price), u"Reach take profit ratio %s ,Current rising price %s" %
                              (up_rate, tick_price))
            if trend_side == 1:
                # 判断是否达到止盈回调
                if tick_price > up_price:
                    # 继续涨了
                    values_dict['up_price'] = tick_price
                    updateValues(robot_id, json.dumps(values_dict))
                    insertLog(platform, robot_id, uid, u"达到止盈率后继续上涨 ,当前上涨价格 %s" %
                              (tick_price), u"Continue to rise after reaching the take-profit ratio, the current price is rising %s" %
                              (tick_price))
                else:
                    down_num = up_price - tick_price
                    down_rate = down_num * 100/up_price
                    if down_rate >= stop_profit_callback_rate:
                        # 达到止盈回调了，卖出所有deal_amount
                        # updateValues(robot_id,'')
                        insertLog(platform, robot_id, uid, u"达到止盈回调率 %s ,当前回调价格 %s" %
                                  (down_rate, tick_price), u"Reach the take-profit callback rate %s ,Current callback price %s" %
                                  (down_rate, tick_price))
                        if platform == 'sinance':
                            token = api_info['secret_key']
                            rst = localOrder(1, token, market_info['market'], values_dict['deal_amount'])
                        else:
                            rst = order(robot_id,1, api_info, market,
                                        values_dict['deal_amount'])
                        print('----------------revenue stop ================')                   
                        print(rst)
                        print('----------------revenue stop end================')   
                        if rst['code'] == 1:
                            order_id = rst['data']['order_id']
                            deal_money = rst['data']['deal_money']
                            deal_amount = rst['data']['deal_stock']
                            deal_fee = rst['data']['deal_fee']
                            price = float(deal_money)/float(deal_amount)
                            side = 1
                            deal_money = float(deal_money)-float(deal_fee)
                            insertOrder(platform, uid, order_id, robot_id, side, market, stock_name,
                                        money_name, deal_money, deal_amount, price, 2, values_dict['pid'])
                            revenue = float(deal_money) - \
                                float(values_dict['deal_money'])
                            insertRevenueLog(
                                platform, robot_id, values_dict['pid'], uid, market, stock_name, money_name, revenue)
                            updateValues(robot_id, '')
                            updateRevenue(robot_id, 0)
                            updateMsg(robot_id, u'卖出成功', u'Successfully sold')
                            insertLog(platform, robot_id, uid, u"卖出：成交总价 %s %s ,成交均价 %s %s,成交数量 %s %s" % (
                                deal_money, money_name, price, money_name, deal_amount, stock_name), u"Sell: total transaction price %s %s ,Average transaction price %s %s, Amount %s %s" % (
                                deal_money, money_name, price, money_name, deal_amount, stock_name))
                            if recycle_status == 0:
                                # 关闭机器人
                                disableRobot(robot_id)
                                insertLog(platform, robot_id,
                                          uid, u"量化机器人已经关闭", u"Quantitative robot has been closed")
                            else:
                                insertLog(platform, robot_id,
                                          uid, u"量化机器人已经重新开启", u"Quantitative robot has restart")

                        else:
                            updateMsg(robot_id, u'卖出失败' + rst['msg'], u'Sell fail' + rst['msg'])
                            insertLog(platform, robot_id, uid,
                                      u'卖出失败' + rst['msg'],
                                      u'Sell Fail' + rst['msg'])
        if tick_price < base_price:
            if values_dict['order_finish'] == 1:
                # 达到最大做单次数后，不能再补仓了
                thread_alive[robot_id] = 0
                return
            if trend_side == 0 or trend_side == 1:
                down_num = base_price - tick_price
                down_rate = down_num * 100/base_price
                if down_rate >= cover_rate:
                    # 下跌到补仓线
                    values_dict['trend_side'] = 2
                    values_dict['down_price'] = tick_price
                    updateValues(robot_id, json.dumps(values_dict))
                    insertLog(platform, robot_id, uid, u"下跌到补仓线 %s ,当前下跌价格 %s" %
                              (down_rate, tick_price), u"Descent to the margin line %s ,Current falling price %s" %
                              (down_rate, tick_price))
            if trend_side == 2:
                # 判断是否达到补仓回调
                if tick_price < down_price:
                    # 继续跌了
                    values_dict['down_price'] = tick_price
                    updateValues(robot_id, json.dumps(values_dict))
                    insertLog(platform, robot_id, uid, u"达到补仓线后继续下跌 ,当前下跌价格 %s" %
                              (tick_price), u"Continue to fall after reaching the margin line, and the current price is falling %s" %
                              (tick_price))
                else:
                    up_num = tick_price - down_price
                    up_rate = up_num * 100/down_price
                    if up_rate >= cover_callback_rate:
                        # 达到补仓回调了，补仓
                        insertLog(platform, robot_id, uid, u"达到补仓回调率 %s ,当前回调价格 %s" %
                                  (up_rate, tick_price), u"Reach the call back rate %s ,Current callback price %s" %
                                  (up_rate, tick_price))
                                  
                        #第一次回调跟回开单下单
                        if order_count == 1:
                            if platform == 'sinance':
                                token = api_info['secret_key']
                                rst = localOrder(2, token, market_info['market'], first_order_value )
                            else:
                                rst = order(robot_id,2, api_info, market, first_order_value )
                        else :

                            if platform == 'sinance':
                                token = api_info['secret_key']
                                rst = localOrder(2, token, market_info['market'], values_dict['deal_money'])
                            else:
                                rst = order(robot_id,2, api_info, market, values_dict['deal_money'])

                        if rst['code'] == 1:
                            order_id = rst['data']['order_id']
                            deal_money = rst['data']['deal_money']
                            deal_amount = rst['data']['deal_stock']
                            deal_fee = rst['data']['deal_fee']
                            price = float(deal_money)/float(deal_amount)
                            side = 2
                            deal_amount = float(deal_amount)-float(deal_fee)
                            insertOrder(platform, uid, order_id, robot_id, side, market, stock_name,
                                        money_name, deal_money, deal_amount, price, 0, values_dict['pid'])
                            values_dict['order_count'] = values_dict['order_count'] + 1
                            values_dict['trend_side'] = 0
                            values_dict['deal_amount'] = float(
                                values_dict['deal_amount']) + float(deal_amount)
                            values_dict['deal_money'] = float(
                                values_dict['deal_money']) + float(deal_money)
                            values_dict['base_price'] = float(
                                values_dict['deal_money'] / values_dict['deal_amount'])
                            # 达到最大做单数量后，标记finish，只能等盈利
                            if values_dict['order_count'] >= max_order_count:
                                # 只能等盈利
                                values_dict['order_finish'] = 1
                                insertLog(platform, robot_id, uid, u"达到最大做单数量次数：单数 %s " %
                                          values_dict['order_count'], u"Reach the maximum number of orders: order %s " %
                                          values_dict['order_count'])
                            updateValues(robot_id, json.dumps(values_dict))
                            updateMsg(robot_id, u'补仓成功', u'Successfully Cover')
                            insertLog(platform, robot_id, uid, u"补仓成功：单数 %s , 成交总价 %s %s ,成交均价 %s %s,成交数量 %s %s" % (
                                values_dict['order_count'], deal_money, money_name, price, money_name, deal_amount, stock_name), u"Successful replenishment: order %s , Total price %s %s ,Average price %s %s,Amount %s %s" % (
                                values_dict['order_count'], deal_money, money_name, price, money_name, deal_amount, stock_name))
                            insertLog(platform, robot_id, uid, u"基准价调整为: %s " %
                                      values_dict['base_price'], u"Base price adjusted to: %s " %
                                      values_dict['base_price'])
                        else:
                            updateMsg(robot_id, u'补仓失败 : ' + rst['msg'], u'cover fail : ' + rst['msg'])
                            insertLog(platform, robot_id, uid,
                                      u'补仓失败 : ' + rst['msg'],
                                      u'Failed to Cover up : ' + rst['msg'])
    else:
        # 新启动的
        # 开始下单
        if platform == 'sinance':
            token = api_info['secret_key']
            rst = localOrder(2, token, market_info['market'], first_order_value)
        else:
            rst = order(robot_id,2, api_info, market, first_order_value)
            print('------fast-------')
            print(rst)
        # print(rst)
        if rst['code'] == 1:
            order_id = rst['data']['order_id']
            deal_money = rst['data']['deal_money']
            deal_amount = rst['data']['deal_stock']
            deal_fee = rst['data']['deal_fee']
            price = float(deal_money)/float(deal_amount)
            side = 2
            pid = str(uuid.uuid4())
            deal_amount = float(deal_amount)-float(deal_fee)
            insertOrder(platform, uid, order_id, robot_id, side, market, stock_name,
                        money_name, deal_money, deal_amount, price, 1, pid)
            values_dict = {'first_order_price': price, 'base_price': price, 'up_price': 0, 'down_price': 0, 'trend_side': 0,
                           'order_count': 1, 'deal_amount': deal_amount, 'deal_money': deal_money, 'order_finish': 0, 'pid': pid}
            updateValues(robot_id, json.dumps(values_dict))
            updateMsg(robot_id, u'下单成功', u'Order Success')
            insertLog(platform, robot_id, uid, u"首单开单：成交总价 %s %s ,成交均价 %s %s,成交数量 %s %s" % (
                deal_money, money_name, price, money_name, deal_amount, stock_name), u"First order: total transaction price %s %s ,Average price %s %s,Amount %s %s" % (
                deal_money, money_name, price, money_name, deal_amount, stock_name))
        else:
            print('------msg-------')
            print(rst)
            print(rst['msg'])
            print('------msg end-------')
            
            updateMsg(robot_id, u'首单开单失败 : ' + rst['msg'], u'First order fail : ' + rst['msg'])
            insertLog(platform, robot_id, uid, u'首单开单失败 : ' + rst['msg'], u'First order fail : ' + rst['msg'])

    #return
    thread_alive[robot_id] = 0


# 读取所有的策略配置
def loadStrategyConfig(cur):
    # read db
    markets_count = cur.execute(
        "select id,platform,market,market_name,type,stock,money from jl_spot_market where status = 1")
    print('db have %d market' % markets_count)
    markets = cur.fetchall()
    # print(markets)
    market_list = {}
    for market in markets:
        market_list[market['id']] = market
    # print(market_list)
    # read api key
    api_count = cur.execute(
        "select id,uid,platform,api_key,secret_key,passphrase from jl_third_api where status = 1")
    print('db have %d jl_third_api ' % api_count)
    apis = cur.fetchall()
    #print(apis)
    api_list = {}
    for api in apis:
        api_list["%s-%s" % (api['platform'], api['uid'])] = api
    # print(api_list)
    cur.execute('SELECT * from jl_quant_robot where status = 1')
    robots = cur.fetchall()
   
    if robots:
        for robot in robots:
            market_id = robot['market_id']
            platform = robot['platform']
            uid = robot['uid']
            robot_id = robot['id']
            if market_id in market_list:
                market_info = market_list[market_id]
            else:
                disableRobot(robot_id)
                updateMsg(robot_id, 'market %s not found' % market_id, 'market %s not found' % market_id)
                insertLog(platform,
                          robot_id, uid, 'market %s  not found , stopped...' % market_id, 'market %s  not found , stopped...' % market_id)
                continue
            if "%s-%s" % (platform, uid) in api_list:
                api_info = api_list["%s-%s" % (platform, uid)]
            else:
                disableRobot(robot_id)
                updateMsg(robot_id, '%s api not found' % platform, '%s api not found' % platform)
                insertLog(platform, robot_id, uid,
                          '%s api not found , stopped...' % platform,
                          '%s api not found , stopped...' % platform)
                continue
            print(robot)
            print(market_info)
            print(api_info)
            _thread.start_new_thread(
                onTick, (robot_id, market_info, api_info))
    else:
        print(u'no robot , wait ...')


if __name__ == '__main__':
    while True:
        try:
            conn = Conn()
            cur = conn.cursor(MySQLdb.cursors.DictCursor)
            loadStrategyConfig(cur)
            cur.close()
            conn.close()
            time.sleep(10)
        except Exception as e:
            print(Exception, ':', e)
            time.sleep(30)
