<template>
    <div class="text-center " v-if="item">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4">
                <el-card class="box-card text">
                    <div class="row">
                        <div class="col-md-6">
                            <div>الاسم</div>
                        </div>

                        <div class="col-md-6">
                            <div>{{ item.user.name }}</div>
                        </div>

                    </div>
                    <div class="row div-back">
                        <div class="col-md-6"> رقم الهاتف</div>
                        <div class="col-md-6">{{ item.address.mobile }}</div>

                    </div>
                    <div class="row">
                        <div class="col-md-6"> العنوان</div>
                        <div class="col-md-6">{{ item.address.address }}</div>
                    </div>
                    <div class="row div-back">
                        <div class="col-md-6">المدينة</div>
                        <div class="col-md-6">{{ item.address.city.name }}</div>

                    </div>
                    <div class="row">
                        <div class="col-md-6"> قيمة</div>
                        <div class="col-md-6">{{item.total}}</div>
                    </div>
                </el-card>
            </div>
            <div class="col-lg-6 col-md-12">
                <el-card class=" text">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">اسم المنتج</th>
                            <th scope="col">سعر المنتج</th>
                            <th scope="col">الكمية</th>


                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(p,index) in item.bill_products">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ p.product.name }}</td>
                            <td>{{ p.product.price }}</td>
                            <td>{{ p.qty }}</td>
                        </tr>

                        </tbody>
                    </table>
                </el-card>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "bill-details",
    data() {
        return {
            item: null,
        }
    },
    mounted() {
        axios.get('/adminData/bills/' + this.$route.params.bill)
            .then((response) => {
                // handle success
                this.item = response.data
                console.log(this.item)
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
</script>

<style scoped>
.text {
    text-align: right;
    font-size: 25px;
}
.div-back{
    background: #f0f9eb;
}
.item {
    padding: 18px 0;
}

.box-card {
}
</style>
