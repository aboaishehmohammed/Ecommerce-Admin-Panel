<template>
    <div>
        <div class="container">
            <el-tabs type="border-card" dir="rtl">
                <el-tab-pane label="يومي" style="text-align:right">
                    <b-form @submit.prevent="getReport('daily')">
                        <b-form-group
                            label="اليوم" style="font-size:20px">
                            <b-form-input
                                v-model="search['daily'].date"
                                type="date"
                                required
                            ></b-form-input>
                        </b-form-group>

                        <b-button type="submit" variant="primary">اختيار</b-button>
                    </b-form>

                    <div class="mt-3" v-if="report.bill_total>0">
                        <el-card class="box-card text">
                            <div class="row" >
                                <div class="col-md-6">
                                    <div>المبلغ</div>
                                </div>
                                <div class="col-md-6">
                                    <div>{{report.bill_total}}</div>
                                </div>


                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="text-center">المنتجات</h2>

                                </div>
                                <div class="card-body" style="overflow-x:auto;">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">اسم المنتج</th>
                                            <th scope="col">الكمبة المباعة</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-for="(item,index) in report.products" v-if="report.products" :key="index">
                                            <th scope="row">{{index+1}}</th>
                                            <td>{{ item.name }}</td>
                                            <td>{{item.sum}}</td>

                                        </tr>

                                        </tbody>
                                    </table>            </div>
                            </div>


                        </el-card>
                    </div>

                </el-tab-pane>
                <el-tab-pane label="شهري">
                    <div>
                        <b-form @submit.prevent="getReport('monthly')">
                            <b-form-group
                                label="الشهر">
                                <b-form-input
                                    v-model="search['monthly'].month"
                                    type="number"
                                    max="12"
                                    min="1"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group
                                label="السنة">
                                <b-form-input
                                    v-model="search['monthly'].year"
                                    type="number"
                                    min="2020"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-button type="submit" variant="primary">اختيار</b-button>
                        </b-form>
                    </div>
                    <div class="mt-3" v-if="report.bill_total>0">
                        <el-card class="box-card text">
                            <div class="row" >
                                <div class="col-md-6">
                                    <div>المبلغ</div>
                                </div>
                                <div class="col-md-6">
                                    <div>{{report.bill_total}}</div>
                                </div>


                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="text-center">المنتجات</h2>

                                </div>
                                <div class="card-body" style="overflow-x:auto;">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">اسم المنتج</th>
                                            <th scope="col">الكمبة المباعة</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-for="(item,index) in report.products" v-if="report.products" :key="index">
                                            <th scope="row">{{index+1}}</th>
                                            <td>{{ item.name }}</td>
                                            <td>{{item.sum}}</td>

                                        </tr>

                                        </tbody>
                                    </table>            </div>
                            </div>


                        </el-card>
                    </div>

                </el-tab-pane>
                <el-tab-pane label="سنوي">
                    <div>
                        <b-form @submit.prevent="getReport('yearly')">
                            <b-form-group
                                label="السنة">
                                <b-form-input
                                    v-model="search['yearly'].year"
                                    type="number"
                                    min="2020"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-button type="submit" variant="primary">اختيار</b-button>
                        </b-form>
                    </div>
                    <div class="mt-3" v-if="report.bill_total>0">
                        <el-card class="box-card text">
                            <div class="row" >
                                <div class="col-md-6">
                                    <div>المبلغ</div>
                                </div>
                                <div class="col-md-6">
                                    <div>{{report.bill_total}}</div>
                                </div>


                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="text-center">المنتجات</h2>

                                </div>
                                <div class="card-body" style="overflow-x:auto;">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">اسم المنتج</th>
                                            <th scope="col">الكمبة المباعة</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-for="(item,index) in report.products" v-if="report.products" :key="index">
                                            <th scope="row">{{index+1}}</th>
                                            <td>{{ item.name }}</td>
                                            <td>{{item.sum}}</td>

                                        </tr>

                                        </tbody>
                                    </table>            </div>
                            </div>


                        </el-card>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </div>
    </div>

</template>

<script>
export default {
    name: "index-reports",
    data() {
        return {
            report: 0,
            search: {
                daily: {
                    date: ""
                },
                monthly: {
                    month: "",
                    year: ""
                },
                yearly: {
                    year: ""
                }

            }
        }
    },
    mounted() {

        this.search['daily']['date'] = new Date().getFullYear() + '-' + (('0' + (1 + new Date().getMonth())).slice(-2))+"-" + ("0" + new Date().getDate()).slice(-2);
        axios.post('/adminData/bills/reports/daily', this.search['daily'])
            .then((response) => {
                // handle success
                this.report = response.data
                console.log(this.report)
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    },

    methods: {
        getReport(typeOfReport) {
            axios.post("/adminData/bills/reports/" + typeOfReport, this.search[typeOfReport])
                .then((response) => {
                // handle success
                this.report = response.data
                console.log(this.report)
            })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });

        }


    }
}
</script>

<style scoped>
.text {
    text-align: center;
    font-size: 25px;
}
</style>
