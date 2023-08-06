<template>
  <div class="main-content">
    <b-row>
      <b-col md="12">
        <b-card class="mb-30">
          <b-row align-v="center">
            <b-col md="3" class="mt-3 mt-md-0">
              <b-form-group
                id="input-group-2"
                :label="$t('from')"
                label-for="input-2"
              >
                <b-form-input
                  id="input-2"
                  type="date"
                  v-model="from"
                ></b-form-input>
              </b-form-group>
            </b-col>

            <b-col md="3" class="mt-3 mt-md-0">
              <b-form-group
                id="input-group-2"
                :label="$t('to')"
                label-for="input-2"
              >
                <b-form-input
                  id="input-2"
                  type="date"
                  v-model="to"
                ></b-form-input>
              </b-form-group>
            </b-col>

            <b-col md="1" class="mt-3 mt-md-0">
              <b-button variant="primary" @click="onSearch">{{
                $t("search")
              }}</b-button>
            </b-col>
            <b-col md="1" class="mt-3 mt-md-0" v-if="canClear">
              <b-button variant="danger" @click="onCancel">{{
                $t("clear")
              }}</b-button>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
    <div style="position: relative">
      <div
        v-if="isLoading"
        style="
          position: absolute;
          background-color: rgba(211, 211, 211, 0.2);
          height: 100%;
          width: 100%;
          z-index: 3;
          display: flex;
          justify-content: center;
          align-items: center;
        "
      >
        <span
          style="
            background-color: #c0dfff;
            color: #409eff;
            padding: 7px 30px;
            border-radius: 3px;
          "
          >{{ $t("loading...") }}</span
        >
      </div>
      <!-- <b-row>
        <b-col lg="12" xl="5" md="12" class="mb-30">
          <b-card>
            <div class="d-flex justify-content-between">
              <h3 class="ul-widget__head-title">{{ $t("pprofit") }}</h3>
            </div>
            <div class="ul-widget__body">
              <div class="ul-widget1">
                <div class="ul-widget__item ul-widget4__users">
                  <div class="ul-widget4__img">
                    <img
                      src="@/assets/images/faces/3.jpg"
                      id="userDropdown"
                      alt=""
                      data-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    />
                  </div>
                  <div class="ul-widget2__info ul-widget4__users-info">
                    <a href="#" class="ul-widget2__title">
                      50% {{ $t("gasFee") }} / 50% {{ $t("gasPanning") }}
                    </a>
                    <span href="#" class="ul-widget2__username"> USDT </span>
                  </div>
                  <span
                    class="ul-widget4__number t-font-boldest text-primary"
                    >{{ this.gasdoublepoint }}</span
                  >
                </div>
                <div class="ul-widget__item ul-widget4__users">
                  <div class="ul-widget2__info ul-widget4__users-info">
                    <a href="#" class="ul-widget2__title">
                      {{ $t("gasFee") }}
                    </a>
                    <span href="#" class="ul-widget2__username"> USDT </span>
                  </div>
                  <span
                    class="ul-widget4__number t-font-boldest text-warning"
                    >{{ this.gaspoint2 }}</span
                  >
                </div>
                <div class="ul-widget__item ul-widget4__users">
                  <div class="ul-widget2__info ul-widget4__users-info">
                    <a href="#" class="ul-widget2__title">
                      {{ $t("gasPanning") }}
                    </a>
                    <span href="#" class="ul-widget2__username"> USDT </span>
                  </div>
                  <span class="ul-widget4__number t-font-boldest text-danger">{{
                    this.gaspoint3
                  }}</span>
                </div>
              </div>
            </div>
          </b-card>
        </b-col>
        <b-col lg="12" xl="7" md="12">
          <b-row>
            <b-col md="6" lg="6">
              <b-card class="mb-30 o-hidden">
                <h6 class="mb-2 text-muted">{{ $t("pin100") }}</h6>
                <p class="mb-1 text-22 font-weight-light">
                  {{ this.pin100_usdt }} USDT
                </p>
                <small class="text-muted"
                  >{{ $t("total") }} {{ this.pin100 }}</small
                >
              </b-card>
            </b-col>
            <b-col md="6" lg="6">
              <b-card class="mb-30 o-hidden">
                <h6 class="mb-2 text-muted">{{ $t("pin100free") }}</h6>
                <p class="mb-1 text-22 font-weight-light">
                  {{ this.pin100_free_usdt }} USDT
                </p>
                <small class="text-muted"
                  >{{ $t("total") }} {{ this.pin100_free }}</small
                >
              </b-card>
            </b-col>
          </b-row>

          <b-row>
            <b-col md="6" lg="6">
              <b-card class="mb-30 o-hidden bg-primary text-white">
                <h6 class="mb-2 text-white">{{ $t("pin250") }}</h6>
                <p class="mb-1 text-22 font-weight-light">
                  {{ this.pin250_usdt }} USDT
                </p>
                <small class="text-white"
                  >{{ $t("total") }} {{ this.pin250 }}</small
                >
              </b-card>
            </b-col>
            <b-col md="6" lg="6">
              <b-card class="mb-30 o-hidden bg-primary text-white">
                <h6 class="mb-2 text-white">{{ $t("pin250free") }}</h6>
                <p class="mb-1 text-22 font-weight-light">
                  {{ this.pin250_free_usdt }} USDT
                </p>
                <small class="text-white"
                  >{{ $t("total") }} {{ this.pin250_free }}</small
                >
              </b-card>
            </b-col>
          </b-row>
        </b-col>
      </b-row> -->
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getDashboard } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      isLoading: true,
      from: "",
      to: "",
      canClear: false,
      gasdoublepoint: 0,
      gaspoint2: 0,
      gaspoint3: 0,
      pin100: 0,
      pin100_free: 0,
      pin100_free_usdt: 0,
      pin100_usdt: 0,
      pin250: 0,
      pin250_free: 0,
      pin250_free_usdt: 0,
      pin250_usdt: 0,
    };
  },
  props: ["success"],
  methods: {
    onSearch() {
      this.pageNumber = 1;
      if (this.from != "" || this.to != "") {
        this.canClear = true;
      }
      this.loadItems();
    },
    onCancel() {
      this.from = "";
      this.to = "";
      this.canClear = false;
      this.loadItems();
    },
    loadItems() {
      var result = getDashboard(this.from, this.to);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.gasdoublepoint = value.data.data.record.gasdoublepoint;
          self.gaspoint2 = value.data.data.record.gaspoint2;
          self.gaspoint3 = value.data.data.record.gaspoint3;
          self.pin100 = value.data.data.record.pin100;
          self.pin100_free = value.data.data.record.pin100_free;
          self.pin100_free_usdt = value.data.data.record.pin100_free_usdt;
          self.pin100_usdt = value.data.data.record.pin100_usdt;
          self.pin250 = value.data.data.record.pin250;
          self.pin250_free = value.data.data.record.pin250_free;
          self.pin250_free_usdt = value.data.data.record.pin250_free_usdt;
          self.pin250_usdt = value.data.data.record.pin250_usdt;
          self.isLoading = false;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.loadItems();
  },
};
</script>

<style>
#fileName span {
  white-space: nowrap;
  overflow: hidden;
  display: inline-block;
}
#fileName span:first-child {
  width: 60px;
  text-overflow: ellipsis;
}
#fileName span + span {
  width: 34px;
  direction: rtl;
  text-align: right;
  /* text-overflow: ellipsis; */
}

.upload-hint {
  position: absolute;
  width: 100%;
  height: 100%;
  border-style: dotted;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.hiddenClass {
  pointer-events: none;
  display: none;
}

.addressWidth {
  max-width: 200px;
}

.txidWidth {
  max-width: 275px;
}
</style>