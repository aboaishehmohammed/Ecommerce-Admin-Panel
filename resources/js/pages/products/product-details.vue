<template>
    <div class="container" v-if="item" dir="rtl">
        <el-card class="box-card text">
            <div class="row div-back">
                <div class="col-md-6">
                    <div>الاسم</div>
                </div>

                <div class="col-md-6">
                    <div>{{ item.name }}</div>
                </div>

            </div>
            <div class="row ">
                <div class="col-md-6"> الكمية المتوفرة</div>
                <div class="col-md-6">{{ item.qty }}</div>

            </div>
            <div class="row div-back">
                <div class="col-md-6">السعر</div>
                <div class="col-md-6">{{ item.price }}</div>
            </div>
            <div class="row mt-2 mb-2">

                <div class="col-md-6">
                    <div>الصورة الرئيسية</div>
                </div>

                <div class="col-md-6">
                    <div><img v-bind:src="'/images/'+item.image_id" alt="" style="width: 80px; height: 50px"></div>
                </div>

            </div>
            <div class="row ">
                <div class="col-md-6">الوصف</div>
                <div class="col-md-6">{{ item.description }}</div>

            </div>
        </el-card>
    </div>

</template>

<script>
export default {
    name: "product-details",
    data() {
        return {
            item: null,
        }
    },
    mounted() {
        axios.get('/adminData/products/' + this.$route.params.product)
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
</style>
