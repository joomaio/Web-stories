const Account = require("../models/account.model")
exports.findAll = (req, res) => {
    Account.getAll((err, data) => {
        if (err)
            res.status(500).send({
                message:
                    err.message || "Some error occurred while retrieving stories."
            });
        else res.send(data);
    })
}
