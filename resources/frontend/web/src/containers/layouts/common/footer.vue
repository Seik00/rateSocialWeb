<template>
  <div class="footer_wrap mt-auto">
    <!-- Footer Start -->
    <div class="app-footer">
      <b-row align-h="around">
        <b-col cols="3" class="px-0">
          <router-link  to="/web/dashboard/dashboard" class="nav-item-hold">
           
            <div class="tap-box" v-if="this.$route.path.includes('dashboard')">
              <img  class="nav-icon" src="../../../assets/images/footer/home_select.png" alt="">
              <div class="flex-grow-1"></div>
              <span class="text-unlock-purple">{{ $t("home") }}</span>
            </div>
            <img v-else class="nav-icon" src="../../../assets/images/footer/home_normal.png" alt="">
            
          </router-link>
        </b-col>

        <b-col cols="3" class="px-0">
          <router-link  to="/web/rating/home" class="nav-item-hold">
           
            <div class="tap-box" v-if="this.$route.path.includes('rating')">
              <img  class="nav-icon" src="../../../assets/images/footer/star_select.png" alt="">
              <div class="flex-grow-1"></div>
              <span class="text-unlock-purple">{{ $t("rating") }}</span>
            </div>
            <img v-else class="nav-icon" src="../../../assets/images/footer/star_normal.png" alt="">
            
          </router-link>
        </b-col>

        <b-col cols="3" class="px-0">
          <router-link  to="/web/boost/boostPage" class="nav-item-hold">
           
            <div class="tap-box" v-if="this.$route.path.includes('boostPage')">
              <img  class="nav-icon" src="../../../assets/images/footer/wallet_select.png" alt="">
              <div class="flex-grow-1"></div>
              <span class="text-unlock-purple">{{ $t("rating") }}</span>
            </div>
            <img v-else class="nav-icon" src="../../../assets/images/footer/wallet_normal.png" alt="">
            
          </router-link>
        </b-col>

        <b-col cols="3" class="px-0">
          <router-link  to="/web/me/mePage" class="nav-item-hold">
           
            <div class="tap-box" v-if="this.$route.path.includes('mePage')">
              <img  class="nav-icon" src="../../../assets/images/footer/profile_select.png" alt="">
              <div class="flex-grow-1"></div>
              <span class="text-unlock-purple">{{ $t("profile") }}</span>
            </div>
            <img v-else class="nav-icon" src="../../../assets/images/footer/profile_normal.png" alt="">
            
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