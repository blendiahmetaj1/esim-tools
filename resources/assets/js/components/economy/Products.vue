<template>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-sm-offset-3">
                <div class="form-group">
                    <select id="buy" name="buyerCurrencyId" class="form-control" v-on:change="changeCurrency">
                        <option value="64">DZD (Algeria)</option>
                        <option value="24">ARS (Argentina)</option>
                        <option value="131">AMD (Armenia)</option>
                        <option value="13">BAM (Bosnia and Herzegovina)</option>
                        <option value="23">BRL (Brazil)</option>
                        <option value="10">BGN (Bulgaria)</option>
                        <option value="119">KHR (Cambodia)</option>
                        <option value="28">CNY (China)</option>
                        <option value="46">COP (Colombia)</option>
                        <option value="156">CY (Cyprus)</option>
                        <option value="51">CZK (Czech Republic)</option>
                        <option value="57">EGP (Egypt)</option>
                        <option value="53">EEK (Estonia)</option>
                        <option value="4">FRF (France)</option>
                        <option value="133">GEL (Georgia)</option>
                        <option value="3">DEM (Germany)</option>
                        <option value="8">HUF (Hungary)</option>
                        <option value="165">ISK (Iceland)</option>
                        <option value="34">INR (India)</option>
                        <option value="29">IDR (Indonesia)</option>
                        <option value="30">IRR (Iran)</option>
                        <option value="38">IEP (Ireland)</option>
                        <option value="33">NIS (Israel)</option>
                        <option value="7">ITL (Italy)</option>
                        <option value="778">KKD (Kekistan)</option>
                        <option value="19">LTL (Lithuania)</option>
                        <option value="72">MAD (Morocco)</option>
                        <option value="41">PKR (Pakistan)</option>
                        <option value="44">PEN (Peru)</option>
                        <option value="54">PHP (Philippines)</option>
                        <option value="1">PLN (Poland)</option>
                        <option value="18">PTE (Portugal)</option>
                        <option value="9">RON (Romania)</option>
                        <option value="2">RUB (Russia)</option>
                        <option value="11">RSD (Serbia)</option>
                        <option value="49">SKK (Slovakia)</option>
                        <option value="5">ESP (Spain)</option>
                        <option value="32">TWD (Taiwan)</option>
                        <option value="80">TND (Tunisia)</option>
                        <option value="22">TRY (Turkey)</option>
                        <option value="6" selected>GBP (United Kingdom)</option>
                        <option value="26">USD (USA)</option>
                        <option value="56">VEF (Venezuela)</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-2">
                <div class="form-group">
                    <select class="form-control" v-on:change="changeResource">
                        <option value="IRON">Iron</option>
                        <option value="GRAIN">Grain</option>
                        <option value="OIL">Oil</option>
                        <option value="STONE">Stone</option>
                        <option value="WOOD">Wood</option>
                        <option value="DIAMONDS">Diamonds</option>
                        <option value="WEAPON">Weapon</option>
                        <option value="HOUSE">House</option>
                        <option value="GIFT">Gift</option>
                        <option value="FOOD">Food</option>
                        <option value="TICKET">Ticket</option>
                        <option value="DEFENSE_SYSTEM">Defense System</option>
                        <option value="HOSPITAL">Hospital</option>
                        <option value="ESTATE">Estate</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-1">
                <div class="form-group">
                    <select class="form-control" v-on:change="changeQuality">
                        <option value="0">All</option>
                        <option value="1">Q1</option>
                        <option value="2">Q2</option>
                        <option value="3">Q3</option>
                        <option value="4">Q4</option>
                        <option value="5">Q5</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-push-3">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Seller</th>
                        <th>Amount</th>
                        <th>Price</th>
                        <th>Gold Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="task in list">
                        <td>{{ task.seller }}</td>
                        <td>{{ task.amount }}</td>
                        <td>{{ task.price }}</td>
                        <td>{{ task.goldPrice }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['server'],
        data: function () {
            return {
                list: [],
                country: 6,
                resource: "IRON",
                quality: 0
            }
        },
        mounted() {
            this.fetch(this.resource, this.country, this.quality);
        },
        methods: {
            fetch: function (resource, country, quality) {
                const f = this;

                this.$http.get('/api/'+this.server+'/product/' + resource + '/' + country + '/' + quality).then(function (response) {
                    const data = response.data;
                    f.$http.get('/api/'+this.server+'/exchange/0/' + country).then(function (response) {
                        for (let i = 0; i < data.length; i++) {
                            data[i].goldPrice = data[i].price * response.data[0].rate;
                        }
                        this.list = data;
                    });

                })
            },
            changeCurrency: function (event) {
                this.country = event.target.value;
                this.fetch(this.resource, this.country, this.quality);
            },
            changeResource: function (event) {
                this.resource = event.target.value;
                this.fetch(this.resource, this.country, this.quality);
            },
            changeQuality: function (event) {
                this.quality = event.target.value;
                this.fetch(this.resource, this.country, this.quality);
            }
        }
    }
</script>
