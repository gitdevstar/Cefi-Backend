const express = require('express');

const router = express.Router();
const TatumController = require('./controller');

router.get("/accounts/create/:userId", (req, res) => {
    let param = req.params;
    TatumController.generateAllAccounts(param.userId).then((accounts) => {
        return res.status(200).json({ 'status': true, 'data': accounts });
    })
    .catch(function (error) {
        console.error("create account issue!", error);
        return res.status(200).json({ 'status': false, 'data': {} });
    });

});

router.get("/account/create/:userId/:currency", (req, res) => {
    let param = req.params;
    TatumController.generateAccount(param.userId, param.currency).then((account) => {
        return res.status(200).json({ 'status': true, 'data': account });
    })
    .catch(function (error) {
        console.error("create account issue!", error);
        return res.status(200).json({ 'status': false, 'message': error });
    });

});

router.get("/account/:accountId", (req, res) => {
    let param = req.params;
    TatumController.getAccount(param.accountId).then((account) => {
        return res.status(200).json({ 'status': true, 'data': account });
    })
    .catch(function (error) {
        console.error("create account issue!", error);
        return res.status(200).json({ 'status': false, 'data': {} });
    });

});

router.get("/account/balance/:accountId", (req, res) => {
    let param = req.params;
    TatumController.getAccountBalance(param.accountId).then((balance) => {
        return res.status(200).json({ 'status': true, 'data': balance });
    })
    .catch(function (error) {
        console.error("create account issue!", error);
        return res.status(200).json({ 'status': false, 'data': {} });
    });

});

router.get("/accounts/customer/:customerId", (req, res) => {
    let param = req.params;
    TatumController.getAccountsByCustomer(param.customerId).then((accounts) => {
        return res.status(200).json({ 'status': true, 'data': accounts });
    })
    .catch(function (error) {
        console.error("create account issue!", error);
        return res.status(200).json({ 'status': false, 'data': {} });
    });

});

router.get("/generate/address/:currency/:xpub", (req, res) => {
    let param = req.params;
    TatumController.generateAddress(param.currency, param.xpub).then((address) => {
        return res.status(200).json({ 'status': true, 'data': address });
    })
    .catch(function (error) {
        console.error("create account issue!", error);
        return res.status(200).json({ 'status': false, 'message': error });
    });

});

router.get("/addresses/:accountId", (req, res) => {
    let param = req.params;
    TatumController.getAddressesByAccount(param.accountId).then((addresses) => {
        return res.status(200).json({ 'status': true, 'data': addresses });
    })
    .catch(function (error) {
        console.error("create account issue!", error);
        return res.status(200).json({ 'status': false, 'data': {} });
    });

});

router.get("/transactions/:accountId", (req, res) => {
    let param = req.params;
    TatumController.getTransactionsByAccount(param.accountId).then((transactions) => {
        return res.status(200).json({ 'status': true, 'data': transactions });
    })
    .catch(function (error) {
        console.error("create account issue!", error);
        return res.status(200).json({ 'status': false, 'data': {} });
    });

});

router.get("/bsc/count/transactions/:address", (req, res) => {
    let param = req.params;
    TatumController.getBSCTransactionsCountByAddress(param.address).then((transactions) => {
        return res.status(200).json({ 'status': true, 'data': transactions });
    })
    .catch(function (error) {
        console.error("create account issue!", error);
        return res.status(200).json({ 'status': false, 'data': {} });
    });

});

router.get("/send/:currency/:from/:to/:amount:privKey", (req, res) => {
    let param = req.params;
    TatumController.sendTransaction(param.currency, param.from, param.to, param.amount, param.privKey).then((transaction) => {
        return res.status(200).json({ 'status': true, 'data': transaction });
    })
    .catch(function (error) {
        console.error("create account issue!", error);
        return res.status(200).json({ 'status': false, 'data': {} });
    });

});


module.exports = router;
