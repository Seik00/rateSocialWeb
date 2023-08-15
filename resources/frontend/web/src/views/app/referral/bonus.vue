<template>
    <div class="main-content d-flex flex-column flex-grow-1 px-4 " style="min-height: 100vh;">
        <div class="appBar">
            <a @click="$router.go(-1)">
                <img src="../../../assets/images/digital/right.svg" alt="">
            </a>
        </div>
        <h3 class="mb-3 font-weight-bold text-34 text-black">{{ $t("referral_bonus") }}</h3>
        <div class="bg-green p-4 position-relative" style="border-radius: 12px;">
            <h5 class="text-greenDark font-weight-bold">Refer a friend and get bonus while they
                deposits </h5>

            <div class="d-flex justify-content-start align-items-center w-100 mt-4">
                <div style="aspect-ratio: 1;">
                    <img src="../../../assets/images/digital/referral_bonus.png" alt="" height="100%">

                </div>
                <div class="ml-4">
                    <p class="text-left text-black font-weight-bold mb-2">Your friend successfully sign up</p>
                    <div>
                        <div class="px-3 bg-white" style="border-radius: 2px;width: fit-content;">
                            <span class="text-greenDark font-weight-bold text-10">You both get RM 5 Bonus</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-flex justify-content-start align-items-center w-100 my-4">
                <div style="aspect-ratio: 1;">
                    <img src="../../../assets/images/digital/referral_bonus.png" alt="" height="100%">

                </div>
                <div class="ml-4">
                    <p class="text-left text-black font-weight-bold mb-2">Your friend successfully sign up</p>
                    <div>
                        <div class="px-3 bg-white" style="border-radius: 2px;width: fit-content;">
                            <span class="text-greenDark font-weight-bold text-10">You both get RM 5 Bonus</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-flex justify-content-start align-items-center w-100 mb-3">
                <div style="aspect-ratio: 1;">
                    <img src="../../../assets/images/digital/referral_bonus.png" alt="" height="100%">

                </div>
                <div class="ml-4">
                    <p class="text-left text-black font-weight-bold mb-2">Your friend successfully sign up</p>
                    <div>
                        <div class="px-3 bg-white" style="border-radius: 2px;width: fit-content;">
                            <span class="text-greenDark font-weight-bold text-10">You both get RM 5 Bonus</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="position-absolute w-100 px-4" style="left: 50%;transform: translateX(-50%);">
                <b-input-group class="form-referral">
                    <b-form-input class="form-control" label="text" v-model="otp" type="text" required>
                    </b-form-input>

                    <b-input-group-append>
                        <b-button>
                            <span v-if="!sending">{{ $t("copy") }}</span>
                        </b-button>
                    </b-input-group-append>
                </b-input-group>

            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>