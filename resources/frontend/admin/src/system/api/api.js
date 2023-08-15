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
		'Authorization': 'Bearer' + localStorage.getItem("userToken"),
		'Access-Control-Allow-Origin': '*',
		'Content-Type': 'application/json',
	};
	return header

}

export function getDownloadLink(postData) {
	const data = request({
		url: current + 'api/global/lookup',
		method: 'get',
		data: postData,
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

export function checkotp(email, otp) {
	const data = request({
		url: current + 'api/global/check-otp?contact='+email+'&otp='+otp,
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

export function getDashboard(from , to) {
	const data = request({
		url: current + 'admin-api/dashboard/home?from='+from+'&to='+to,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getAdminList(page) {
	const data = request({
		url: current + 'admin-api/user/admin_list?page='+page,
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
		url: current + 'admin-api/user/user_list?page='+postData+'&username='+username+'&mobile_no='+phone+'&uid='+uid,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getOtpRecord(postData, phone) {
	const data = request({
		url: current + 'admin-api/record/otpRecord?page='+postData+'&contact='+phone,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getMiningList() {
	const data = request({
		url: current + 'admin-api/user/mining_list',
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getMemberTree(username) {
	const data = request({
		url: current + 'admin-api/team/sponsorTree?username='+username,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function jstree_ajax_data(parent, id) {
	const data = request({
		url: current + 'admin-api/team/jstree_ajax_data?uid='+id+'&parent='+parent,
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

export function update_setting(postData) {
	const data = request({
		url: current + 'admin-api/user/userSetting',
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
		url: current + 'admin-api/wallet/walletChangeRec?page='+pageNumber+ '&wallet_type='+wallet_type+ '&username='+username+ '&from='+from+ '&to='+to,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}
export function getADAdjust(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/trading/adAdjustRec?page='+pageNumber+ '&username='+username+ '&from='+from+ '&to='+to,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getDepositList(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/wallet/depositList?page='+pageNumber+ '&from='+from+ '&to='+to+ '&username='+username,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function reloadDeposit(pageNumber) {
	const data = request({
		url: current + 'admin-api/wallet/reloadRecord?page='+pageNumber,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getTradeRobot(pageNumber, username, platform) {
	const data = request({
		url: current + 'admin-api/trade/tradeRobot?page='+pageNumber + '&uid=' + username + '&platform=' + platform,
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
		url: current + 'admin-api/trade/tradePlan?page='+pageNumber,
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
		url: current + 'admin-api/trade/orderList?page='+pageNumber+'&coin='+coin+ '&platform='+platform+ '&username='+username+ '&from='+from+ '&to='+to,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getRevenueList(pageNumber, coin, platform, username, from, to) {
	const data = request({
		url: current + 'admin-api/trade/revenueList?page='+pageNumber+'&coin='+coin+ '&platform='+platform+ '&username='+username+ '&from='+from+ '&to='+to,
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

export function daAdjustWallet(postData) {
	const data = request({
		url: current + 'admin-api/trading/daAdjustWallet',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getWithdrawList(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/wallet/withdrawList?page='+pageNumber+ '&from='+from+ '&to='+ to + '&username='+username,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getWithdrawHis(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/wallet/withdrawHis?page='+pageNumber+ '&from='+from+ '&to='+to+ '&username='+username,
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
		url: current + 'admin-api/spot-market/spotMarketList?page='+page,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getSpotMarketInfo(id) {
	const data = request({
		url: current + 'admin-api/spot-market/spotMarketInfo?id='+id,
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
		url: current + 'admin-api/package/userRobotPackage?page='+pageNumber,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getWalletRecord(wallet, username, from, to, pageNumber) {
	const data = request({
		url: current + 'admin-api/record/walletRecord?page='+pageNumber+'&wallet='+wallet+ '&username='+username+ '&from='+from+ '&to='+to,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getBonusRecord(type, username, from, to, pageNumber) {
	const data = request({
		url: current + 'admin-api/record/bonusRecord?page='+pageNumber+'&bonus='+type+ '&username='+username+ '&from='+from+ '&to='+to,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getTicketList(pageNo) { 
	const data = request({
		url: current + 'admin-api/customer/ticketList?page='+pageNo,
		method: 'get',
		// data: postData,
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

export function moneyCount() { 
	const data = request({
		url: current + 'admin-api/dashboard/header',
		method: 'get',
		// data: postData,
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
		url: current + 'admin-api/pin/pinList?page='+page,
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
		url: current + 'admin-api/news/newsList?page='+page,
		method: 'get',
		// data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getNewsInfo(id) {
	const data = request({
		url: current + 'admin-api/news/newsInfo?id='+id,
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

export function getProductList(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/product/productList?page='+pageNumber+ '&from='+from+ '&to='+to+ '&username='+username,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function controlProduct(postData) {
	const data = request({
		url: current + 'admin-api/product/productControl',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getCountryList(username, from, to, pageNumber) {
	const data = request({
		url: current + 'admin-api/country/coutryList?page='+pageNumber+ '&from='+from+ '&to='+to+ '&username='+username,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function controlCountry(postData) {
	const data = request({
		url: current + 'admin-api/country/countryControl',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getBankList(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/country/bankList?page='+pageNumber+ '&from='+from+ '&to='+to+ '&username='+username,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function controlBank(postData) {
	const data = request({
		url: current + 'admin-api/country/bankControl',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function controlDeposit(postData) {
	const data = request({
		url: current + 'admin-api/wallet/depositControl',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getDepositCoinList(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/wallet/depositCoinList?page='+pageNumber+ '&from='+from+ '&to='+to+ '&username='+username,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function controlCoinDeposit(postData) {
	const data = request({
		url: current + 'admin-api/wallet/depositCoinControl',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getdepositRequestList(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/wallet/depositRequestList?page='+pageNumber+ '&from='+from+ '&to='+to+ '&username='+username,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function dodepositRequestControl(postData) {
	const data = request({
		url: current + 'admin-api/wallet/depositRequestControl',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getWithdrawCashList(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/wallet/withdrawCashList?page='+pageNumber+ '&from='+from+ '&to='+ to + '&username='+username,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function dowithdrawCashControl(postData) {
	const data = request({
		url: current + 'admin-api/wallet/withdrawCashControl',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getWithdrawCashHis(pageNumber, from, to, username) {
	const data = request({
		url: current + 'admin-api/wallet/withdrawCashHis?page='+pageNumber+ '&from='+from+ '&to='+to+ '&username='+username,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function editWithdrawCashControl(postData) {
	const data = request({
		url: current + 'admin-api/wallet/editWithdrawCash',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function editAddress(postData) {
	const data = request({
		url: current + 'admin-api/wallet/editWithdrawCoin',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function searchByPrice(price) {
	const data = request({
		url: current + 'admin-api/product/getProductByPrice?price='+price,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function getDAPrice(pageNumber) {
	const data = request({
		url: current + 'admin-api/trading/daPriceList?page='+pageNumber,
		method: 'get',
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function controlDAPrice(postData) {
	const data = request({
		url: current + 'admin-api/trading/daAdjustPrice',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}

export function depositManage(postData) {
	const data = request({
		url: current + 'admin-api/wallet/depositManageControl',
		method: 'post',
		data: postData,
		headers: retHeader()
	});

	return Promise.resolve(data);
}