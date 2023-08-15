<template>
    <div class="main-content d-flex flex-column flex-grow-1 px-4 position-relative" style="height: 100vh;">
        <div class="appBar">
            <a @click="$router.go(-1)">
                <img src="../../../assets/images/digital/right.svg" alt="">
            </a>
        </div>
        <h3 class="mb-3 font-weight-bold text-black text-34" style="z-index: 3">{{ $t("rating_record") }}</h3>
        <h5 class="font-weight-bold mt-4">30 July 2023</h5>
        <b-card class="position-relative mb-2">
            <div class="status">Completed</div>
            <div class="row p-1">
                <div class="col-3">
                    <img src="../../../assets/images/digital/app-example.png" alt="">

                </div>
                <div class="col-8">
                    <p class="text-black font-weight-bold mb-1">Facebook</p>
                    <p class="mb-1 text-10">Time : 13:20 PM / 30 July 2023</p>
                    <p class="mb-1 text-10 text-brightGreen font-weight-bold">Profit : RM 2.50</p>

                </div>

            </div>

        </b-card>
    </div>
</template>

<script>
export default {

}
</script>