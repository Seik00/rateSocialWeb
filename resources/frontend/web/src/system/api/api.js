import request from '../../system/request';
import config from '../../system/config';


var current = config.url;
// var current = location.origin+'/';

// function current {
// 	// console.log(current);
// 	// return current+'/';
// 	return config.url;

// }

function retHeader() {
	const header = {
		'Authorization': 'Bearer' + localStorage.getItem("boostToken"),
		'Access-Control-Allow-Origin': '*',
		'Content-Type': 'application/json',
	};
	return header

}

export function placeOrder(postData) {
	const data = request({
		url: current + 'api/trade/placeOrder',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function orderList() {
	const data = request({
		url: current + 'api/trade/orderList',
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function myOrder(page) {
	const data = request({
		url: current + 'api/trade/myOrder?page='+page,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}
export function cancelOrder(postData) {
	const data = request({
		url: current + 'api/trade/cancelOrder',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function market() {
	const data = request({
		url: current + 'api/trade/market',
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function marketInfo(id) {
	const data = request({
		url: current + 'api/trade/marketInfo?trade_market_id='+id,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function assetLog(coin, page, searchParam) {
	const data = request({
		url: current + 'api/trade/assetLog?coin='+coin + '&page=' + page + searchParam,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function asset() {
	const data = request({
		url: current + 'api/trade/asset',
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function marketChart(type) {
	const data = request({
		url: current + 'api/trade/marketChart?trade_pair='+type,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function requestOTP(postData) {
	const data = request({
		url: current + 'api/member/requestUserOTP',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function checkOTP(postData) {
	const data = request({
		url: current + 'api/member/checkUserOTP',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function changePassword(postData) {
	const data = request({
		url: current + 'api/member/change-password',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function changeSecPassword(postData) {
	const data = request({
		url: current + 'api/member/change-secpassword',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function forgetSecPassword(postData) {
	const data = request({
		url: current + 'api/member/reset-secpassword',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function forgetPassword(postData) {
	const data = request({
		url: current + 'api/auth/reset-password',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

// export function getDepositAddress() {
// 	const data = request({
// 		url: current + 'api/wallet/depositAddress',
// 		method: 'post',
// 		headers: retHeader()
// 	});

// 	return Promise.resolve(data);
// }

export function getDepositRecord(type,page) {
	const data = request({
		url: current + 'api/wallet/deposit-record?deposit_type='+type+'&page='+page,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getBankInfo() {
	const data = request({
		url: current + 'api/member/get-bank-info',
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function setBankInfo(postData) {
	const data = request({
		url: current + 'api/member/user-bank',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getCoinInfo() {
	const data = request({
		url: current + 'api/member/get-user-info',
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function setCoinInfo(postData) {
	const data = request({
		url: current + 'api/member/update-address',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function withdraw(postData) {
	const data = request({
		url: current + 'api/wallet/withdraw',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function withdrawDa(postData) {
	const data = request({
		url: current + 'api/wallet/withdrawDaFrozen',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function withdrawCash(postData) {
	const data = request({
		url: current + 'api/wallet/withdrawCash',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getWithdrawRecord(type, page) {
	const data = request({
		url: current + 'api/wallet/withdraw-record?withdraw_type='+type+'&page='+page,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function transfer(postData) {
	const data = request({
		url: current + 'api/wallet/wallet-transafer',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getTransferRecord() {
	const data = request({
		url: current + 'api/wallet/wallet-tranfer-record',
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getUserWalletRecord(postData, page) {
	const data = request({
		url: current + 'api/record/wallet-record?wallet=' + postData + '&page=' + page,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getTotalRevenue(start_date, end_date) {
	const data = request({
		url: current + 'api/trade-revenue/revenueTotal?start_date=' + start_date + '&end_date=' + end_date,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getRevenueDay(date) {
	const data = request({
		url: current + 'api/trade-revenue/revenueDay?date=' + date,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getTeam(page) {
	const data = request({
		url: current + 'api/team/robotTeam?page=' + page,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getTeamRevenue(start_date, end_date) {
	const data = request({
		url: current + 'api/team/teamRevenue?start_date=' + start_date + '&end_date=' + end_date,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function addAPI(postData) {
	const data = request({
		url: current + 'api/trade-account/addAccount',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getBalance(postData) {
	const data = request({
		url: current + 'api/trade-account/accountBalance',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getAPI(postData) {
	const data = request({
		url: current + 'api/trade-account/accountInfo',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function removeAPI(postData) {
	const data = request({
		url: current + 'api/trade-account/removeAccount',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getPinRecord() {
	const data = request({
		url: current + 'api/pin/pinRecord',
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}
export function buyPin(postData) {
	const data = request({
		url: current + 'api/pin/buyPin',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}
export function activatePin(postData) {
	const data = request({
		url: current + 'api/pin/activePin',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getRobotList(postData) {
	const data = request({
		url: current + 'api/trade-robot/robotList',
		method: 'get',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getMarketList(postData) {
	const data = request({
		url: current + 'api/trade-robot/marketList?type=spot&platform=' + postData,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getRobotInfo(postData) {
	const data = request({
		url: current + 'api/trade-robot/robotInfo?robot_id=' + postData,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getAccountInfo(postData) {
	const data = request({
		url: current + 'api/trade-account/accountInfo',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function createRobot(postData) {
	const data = request({
		url: current + 'api/trade-robot/create',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function editRobot(postData) {
	const data = request({
		url: current + 'api/trade-robot/edit',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function play_Robot(postData) {
	const data = request({
		url: current + 'api/trade-robot/enable',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function pause_Robot(postData) {
	const data = request({
		url: current + 'api/trade-robot/disable',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function strategy(postData) {
	const data = request({
		url: current + 'api/trade-robot/changeRecycle',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function clearanceSale(postData) {
	const data = request({
		url: current + 'api/trade-robot/clean',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function margin(postData) {
	const data = request({
		url: current + 'api/trade-robot/restock',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getMemberInfo() {
	const data = request({
		url: current + 'api/member/get-member-info',
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getDownloadLink() {
	const data = request({
		url: current + 'api/global/lookup',
		method: 'get',
		// headers: retHeader()
	});

	return Promise.resolve(data);
}

export function sendOtp(postData) {
	const data = request({
		url: current + 'api/global/sent-otp',
		method: 'post',
		data: postData,
		// headers: retHeader()
	});

	return Promise.resolve(data);
}

export function checkOtpWithoutToken(email, otp) {
	const data = request({
		url: current + 'api/global/check-otp?email=' + email + '&code=' + otp,
		method: 'get',
		// data: postData,
		// headers: retHeader()
	});

	return Promise.resolve(data);
}

export function country_list(postData) {
	const data = request({
		url: current + 'api/global/country_list',
		method: 'get',
		data: postData,
		// headers: retHeader()
	});

	return Promise.resolve(data);
}

export function signUp(postData) {
	const data = request({
		url: current + 'api/auth/signup',
		method: 'post',
		data: postData,
		// headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getDashboard(from, to) {
	const data = request({
		url: current + 'admin-api/dashboard/home?from=' + from + '&to=' + to,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getAdminList(page) {
	const data = request({
		url: current + 'admin-api/user/admin_list?page=' + page,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function create_admin(postData) {
	const data = request({
		url: current + 'admin-api/user/create_admin',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function update_admin(postData) {
	const data = request({
		url: current + 'admin-api/user/update_admin',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function delete_admin(postData) {
	const data = request({
		url: current + 'admin-api/user/delete_admin',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getUserList(postData, username, phone, uid) {
	const data = request({
		url: current + 'admin-api/user/user_list?page=' + postData + '&username=' + username + '&mobile_no=' + phone + '&uid=' + uid,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getMemberTree(userID) {
	const data = request({
		url: current + 'api/team/downline-new?parent=' + userID,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function jstree_ajax_data(parent, id) {
	const data = request({
		url: current + 'admin-api/team/jstree_ajax_data?uid=' + id + '&parent=' + parent,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function update_pwd(postData) {
	const data = request({
		url: current + 'admin-api/user/updatePwd',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function update_user(postData) {
	const data = request({
		url: current + 'admin-api/user/updateUser',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function registerMember(postData) {
	const data = request({
		url: current + 'admin-api/user/registerMember',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getWalletChangeRec(pageNumber, wallet_type, from, to, username) {
	const data = request({
		url: current + 'admin-api/wallet/walletChangeRec?page=' + pageNumber + '&wallet_type=' + wallet_type + '&username=' + username + '&from=' + from + '&to=' + to,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getDepositList(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/wallet/depositList?page=' + pageNumber + '&from=' + from + '&to=' + to + '&username=' + username,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function reloadDeposit(pageNumber) {
	const data = request({
		url: current + 'admin-api/wallet/reloadRecord?page=' + pageNumber,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getTradeRobot(pageNumber, username, platform) {
	const data = request({
		url: current + 'admin-api/trade/tradeRobot?page=' + pageNumber + '&uid=' + username + '&platform=' + platform,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function deleteValueStr(postData) {
	const data = request({
		url: current + 'admin-api/trade/deleteValueStr',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getTradePlan(pageNumber) {
	const data = request({
		url: current + 'admin-api/trade/tradePlan?page=' + pageNumber,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function editPlan(postData) {
	const data = request({
		url: current + 'admin-api/trade/editPlan',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getOrderList(pageNumber, coin, platform, username, from, to) {
	const data = request({
		url: current + 'admin-api/trade/orderList?page=' + pageNumber + '&coin=' + coin + '&platform=' + platform + '&username=' + username + '&from=' + from + '&to=' + to,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getRevenueList(pageNumber, coin, platform, username, from, to) {
	const data = request({
		url: current + 'admin-api/trade/revenueList?page=' + pageNumber + '&coin=' + coin + '&platform=' + platform + '&username=' + username + '&from=' + from + '&to=' + to,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function changeWallet(postData) {
	const data = request({
		url: current + 'admin-api/wallet/changeWallet',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getWithdrawList(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/wallet/withdrawList?page=' + pageNumber + '&from=' + from + '&to=' + to + '&username=' + username,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getWithdrawHis(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/wallet/withdrawHis?page=' + pageNumber + '&from=' + from + '&to=' + to + '&username=' + username,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function withdrawControl(postData) {
	const data = request({
		url: current + 'admin-api/wallet/withdrawControl',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getSpotMarketList(page) {
	const data = request({
		url: current + 'admin-api/spot-market/spotMarketList?page=' + page,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getSpotMarketInfo(id) {
	const data = request({
		url: current + 'admin-api/spot-market/spotMarketInfo?id=' + id,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function controlSpotMarketControl(postData) {
	const data = request({
		url: current + 'admin-api/spot-market/spotMarketControl',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getUserRobotPackage(pageNumber) {
	const data = request({
		url: current + 'admin-api/package/userRobotPackage?page=' + pageNumber,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getWalletRecord(wallet, username, from, to, pageNumber) {
	const data = request({
		url: current + 'admin-api/record/walletRecord?page=' + pageNumber + '&wallet=' + wallet + '&username=' + username + '&from=' + from + '&to=' + to,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getBonusRecord(type, username, from, to, pageNumber) {
	const data = request({
		url: current + 'admin-api/record/bonusRecord?page=' + pageNumber + '&bonus=' + type + '&username=' + username + '&from=' + from + '&to=' + to,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function createTicket(postData) {
	const data = request({
		url: current + 'api/ticket/create-ticket',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getTicket(page) {
	const data = request({
		url: current + 'api/ticket/get-ticket?page='+page,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function readTicket(id) {
	const data = request({
		url: current + 'api/ticket/read-ticket?id='+id,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}



export function countRead() {
	const data = request({
		url: current + 'admin-api/customer/countRead',
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function markRead(postData) {
	const data = request({
		url: current + 'admin-api/customer/markRead',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function controlTicket(postData) {
	const data = request({
		url: current + 'admin-api/customer/ticketControl',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getPinList(page) {
	const data = request({
		url: current + 'admin-api/pin/pinList?page=' + page,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function addPin(postData) {
	const data = request({
		url: current + 'admin-api/pin/generatePin',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getNewsList(page) {
	const data = request({
		url: current + 'admin-api/news/newsList?page=' + page,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getNewsInfo(id) {
	const data = request({
		url: current + 'admin-api/news/newsInfo?id=' + id,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function controlNews(postData) {
	const data = request({
		url: current + 'admin-api/news/newsControl',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function login(postData) {
	const data = request({
		url: current + 'api/auth/login',
		method: 'post',
		data: postData
	});
	return Promise.resolve(data);

}

export function systemConfig() {
	const data = request({
		url: current + 'admin-api/setting/systemConfig',
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function saveSystemConfig(postData) {
	const data = request({
		url: current + 'admin-api/setting/saveConfig',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function packageConfig() {
	const data = request({
		url: current + 'admin-api/setting/packageConfig',
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function savePackageConfig(postData) {
	const data = request({
		url: current + 'admin-api/setting/savePackage',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getOrderInfo() {
	const data = request({
		url: current + 'api/order/orderInfo',
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function checkOrder() {
	const data = request({
		url: current + 'api/order/checkOrder',
		method: 'post',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function boostOrder(postData) {
	const data = request({
		url: current + 'api/order/boostOrder',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getDepositBank() {
	const data = request({
		url: current + 'api/wallet/getDepositBank',
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}


export function getDepositAddress() {
	const data = request({
		url: current + 'api/wallet/getDepositAddress',
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function doDeposit(postData) {
	const data = request({
		url: current + 'api/wallet/doDeposit',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function doDepositCoin(postData) {
	const data = request({
		url: current + 'api/wallet/doDepositCoin',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function upload(postData) {
	const data = request({
		url: current + 'api/upload/upload-file',
		method: 'post',
		data: postData,
		headers: {
			'Authorization': 'Bearer' + localStorage.getItem("boostToken"),
			'Access-Control-Allow-Origin': '*',
			'Content-Type': 'multipart/form-data',
		}
	});

	return Promise.resolve(data);
}

export function logout() {
	const data = request({
		url: current + 'api/auth/logout',
		method: 'post',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function doRequestDeposit(postData) {
	const data = request({
		url: current + 'api/wallet/requestMakeDeposit',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function checkAllowDeposit() {
	const data = request({
		url: current + 'api/wallet/checkAllowDeposit',
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function setSecPassword(postData) {
	const data = request({
		url: current + 'api/member/set-secpassword',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getUserBonusRecord(postData, page) {
	const data = request({
		url: current + 'api/record/bonus-record?bonus=' + postData + '&page=' + page,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getUserNewsList(language,news_type,page) {
	const data = request({
		url: current + 'api/news/news-list?language=' + language  + '&news_type=' + news_type+ '&page=' + page,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}
