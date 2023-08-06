<template>
  <div class="footer_wrap mt-auto">
    <!-- Footer Start -->
    <div class="app-footer">
      <b-row align-h="around">
        <b-col cols="3" class="px-0">
          <router-link  to="/web/dashboard/dashboard" class="nav-item-hold">
           
            <div class="tap-box" v-if="this.$route.path.includes('dashboard')">
              <img  class="nav-icon" src="../../../assets/images/digital/house.svg" alt="">
              <span class="nav-text">{{ $t("home") }}</span>
            </div>
            <img v-else class="nav-icon" src="../../../assets/images/digital/house.svg" alt="">
            
          </router-link>
        </b-col>

        <b-col cols="3" class="px-0">
          <router-link  to="/web/myWallet/walletRecord" class="nav-item-hold">
           
            <div class="tap-box" v-if="this.$route.path.includes('walletRecord')">
              <img  class="nav-icon" src="../../../assets/images/digital/clock.svg" alt="">
              <span class="nav-text">{{ $t("record") }}</span>
            </div>
            <img v-else class="nav-icon" src="../../../assets/images/digital/clock.svg" alt="">
            
          </router-link>
        </b-col>

        <b-col cols="3" class="px-0">
          <router-link  to="/web/boost/boostPage" class="nav-item-hold">
           
            <div class="tap-box" v-if="this.$route.path.includes('boostPage')">
              <img  class="nav-icon" src="../../../assets/images/digital/shopping-bag (2).svg" alt="">
              <span class="nav-text">{{ $t("rating") }}</span>
            </div>
            <img v-else class="nav-icon" src="../../../assets/images/digital/shopping-bag (2).svg" alt="">
            
          </router-link>
        </b-col>

        <b-col cols="3" class="px-0">
          <router-link  to="/web/me/mePage" class="nav-item-hold">
           
            <div class="tap-box" v-if="this.$route.path.includes('mePage')">
              <img  class="nav-icon" src="../../../assets/images/digital/user-avatar.svg" alt="">
              <span class="nav-text">{{ $t("profile") }}</span>
            </div>
            <img v-else class="nav-icon" src="../../../assets/images/digital/user-avatar.svg" alt="">
            
          </router-link>
        </b-col>

      </b-row>
      <!-- fotter end -->
    </div>
  </div>
</template> 
<script>
export default {
  data() {
    return {};
  },
  methods: {},
};
</script>


<style lang="scss" scoped></style> 