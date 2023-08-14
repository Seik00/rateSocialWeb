<template>
    <div class="main-content d-flex flex-column flex-grow-1 px-4 " style="min-height: 100vh;">
        <div class="appBar">
            <a @click="$router.go(-1)">
                <img src="../../../assets/images/digital/right.svg" alt="">
            </a>
        </div>
        <h3 class="mb-3 font-weight-bold text-black">{{ $t("rating") }}</h3>

        <b-card class="mb-1 mt-4 p-2 bg-darkpurple">
            <div class="d-flex justify-content-between align-items-end mb-3">

                <h6 class="font-weight-bold mb-0 text-white">{{ $t('balance') }}</h6>
                <span class="text-14 text-white font-weight-bold">{{ currentPackage }} <img height="14px"
                        src="../../../assets/images/digital/currency.svg" alt=""></span>
            </div>
            <div class="d-flex align-items-end">
                <h3 class="font-weight-bold mb-0 text-white">USDT {{ point1 }}</h3>

            </div>
        </b-card>
        <b-card class="mb-3 mt-4 p-2 bg-darkpurple">
            <h5 class="font-weight-bold mb-0 text-white">{{ $t('your_profile') }}</h5>
            <b-row class="mb-2 mt-3">
                <b-col cols="12" class="mb-4">
                    <b-card class="card-primary">
                        <div class="d-flex align-items-center">
                            <div class="mr-3 h-100" style="aspect-ratio: 1;flex-grow: 3;"></div>
                            <div style="flex-grow: 5;">
                                <span class=" text-white">Today App Rated</span>
                                <h4 class="text-white mb-0 font-weight-bold"><span class="">10</span> <span
                                        class="">/ 35</span></h4>
                            </div>

                        </div>

                    </b-card>
                </b-col>
                <b-col cols="12" class="">
                    <b-card class="">
                        <div class="d-flex align-items-center">
                            <div class="mr-3 h-100" style="aspect-ratio: 1;flex-grow: 3;"></div>
                            <div style="flex-grow: 5;">
                                <span class=" text-green">Today App Rated</span>
                                <h4 class="text-green mb-0 font-weight-bold"><span class="">10</span> <span
                                        class="">/ 35</span></h4>
                            </div>

                        </div>

                    </b-card></b-col>
            </b-row>

        </b-card>
    </div>
</template>

<script>
export default {

}
</script>