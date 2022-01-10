const Tatum = require('@tatumio/tatum');

class TatumController {
    constructor() {
        this.testnet = true;
    }


    async generateAllAccounts(userId) {
        var coins = ["ETH","BTC"];

        var customer = {
            "accountingCurrency": "USD",
            "customerCountry" : "US",
            "externalId": userId,
            "providerCountry" : "US"
        };
        data = array();
        try {
            var data = new Array();
            coins.foreach((coin, index) => {
                try {

                    var wallet = Tatum.generateWallet(coin, true);
                    wallet = JSON.parse(wallet);
                    var accountData = {
                        "currency": coin,
                        "xpub": wallet.xpub,
                        "customer": customer,
                        "accountringCurrency": "USD"
                    };
                    data["accounts"][index] = accountData;
                } catch (error) {
                    throw error;
                }

            });

            try {
                var accounts = await Tatum.createAccounts(data);
                return accounts;
            } catch (error) {
                throw error;
            }
        } catch (error) {
            throw error
        }
    }

    async generateAccount(userId, coin) {

        var customer = {
            "accountingCurrency": "USD",
            "customerCountry" : "US",
            "externalId": userId,
            "providerCountry" : "US"
        };
        var data = new Array();
        try {
            try {

                var wallet = await Tatum.generateWallet(coin, true);
                console.log("wallet", wallet);
                // wallet = JSON.parse(wallet);
                var accountData = {
                    "currency": coin,
                    "xpub": wallet.xpub,
                    "customer": customer,
                    "accountringCurrency": "USD"
                };
            } catch (error) {
                throw error;
            }

            try {
                var account = await Tatum.createAccount(accountData);
                return account;
            } catch (error) {
                throw error;
            }
        } catch (error) {
            throw error
        }
    }

    async getAccount(accountId) {
        try {
            var account = await Tatum.getAccountById(accountId);
            return account;
        } catch (error) {
            throw error;
        }
    }

    async getAccountBalance(accountId) {
        try {
            var balance = await Tatum.getAccountBalance(accountId);
            return balance;
        } catch (error) {
            throw error;
        }
    }

    async getAccountsByCustomer(customerId) {
        try {
            var accounts = await Tatum.getAccountsByCustomerId(customerId);
            return accounts;
        } catch (error) {
            throw error;
        }
    }

    async getAddressesByAccount(accountId) {
        try {
            var addresses = await Tatum.getDepositAddressesForAccount(accountId);
            return addresses;
        } catch (error) {
            throw error;
        }
    }

    async getBSCTransactionsCountByAddress(address) {
        try {
            var transactions = await Tatum.bscGetTransactionsCount(address);
            return transactions;
        } catch (error) {
            throw error;
        }
    }

    async getTransactionsByAccount(accountId) {
        try {
            var filter = {
                id: accountId
            }
            var transactions = await Tatum.getTransactionsByAccount(filter);
            return transactions;
        } catch (error) {
            throw error;
        }
    }

    async generateAddress(coin, xpub) {
        try {
            if(coin === "BNB") {
                var address = await Tatum.generateAddressFromPrivatekey(coin, this.testnet, xpub);
            } else
            var address = await Tatum.generateAddressFromXPub(coin, this.testnet, xpub); // don't need testnet flag for ETH. don't care
            return address;
        } catch (error) {
            throw error;
        }
    }

    async sendTransaction(currency, from, to, amount, privKey) {
        try {
            var data = {
                to: to,
                amount: amount,
                currency: currency,
                // contractAddress?: string
            }
            var address = await Tatum.sendBscOrBep20Transaction(data);
            return address;
        } catch (error) {
            throw error;
        }
    }
}

module.exports = new TatumController();
