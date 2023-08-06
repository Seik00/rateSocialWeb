<template>
  <div class="">
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
      <b-button
        type="button"
        variant="outline-primary"
        class="mb-4"
        @click="backpage"
      >
        <i class="dd-arrow i-Arrow-Left"></i
      ></b-button>

      <b-tabs pills align="start">
        <b-tab no-body :title="$t('radical')" active @click="radical">
          <b-row align-h="center" @submit="postData">
            <b-col md="5" class="p-0">
              <b-card>
                <b-form>
                  <b-form-group
                    id="input-group-1"
                    :label="$t('gas')"
                    label-for="input-1"
                  >
                    <b-form-input
                      id="input-1"
                      v-model="balance"
                      type="text"
                      readonly
                      required
                    ></b-form-input>
                  </b-form-group>

                  <!-- <b-form-group
                id="input-group-2"
                :label="$t('gas')"
                label-for="input-2"
              >
                <b-form-input
                  id="input-2"
                  v-model="form.first_order_value"
                  type="number"
                  required
                ></b-form-input>
              </b-form-group> -->
                  <b-form-group
                    id="input-group-2"
                    :label="$t('first_buy_in_amount')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.first_order_value"
                      type="number"
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-row class="form-group" align-h="between">
                    <b-col cols="8">
                      <label for="first_order_double" class="col-form-label">{{
                        $t("first_order_double")
                      }}</label>
                    </b-col>
                    <b-col cols="4" class="py-2">
                      <label class="switch switch-primary mr-3">
                        <input
                          type="checkbox"
                          v-model="form.first_order_double"
                        />
                        <span class="slider"></span>
                      </label>
                    </b-col>
                  </b-row>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('numbers_of_cover_up')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.max_order_count"
                      type="number"
                      @change="setMarginConfig"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('take_profit_ratio')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.stop_profit_rate"
                      type="number"
                      required
                      step="any"
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('earnings_callback')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.stop_profit_callback_rate"
                      type="number"
                      step="any"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('margin_call_drop')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.cover_rate"
                      type="number"
                      @change="setMarginConfig"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-button
                    block
                    type="button"
                    class="form-control py-1 px-2 my-3"
                    @click="openModal()"
                    >{{ $t("margin_call_setting") }}
                  </b-button>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('buy_in_callback')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.cover_callback_rate"
                      type="number"
                      step="any"
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    :label="$t('strategy_type')"
                    v-slot="{ ariaDescribedby }"
                  >
                    <b-form-radio-group
                      id="radio-group-2"
                      v-model="form.recycle_status"
                      :aria-describedby="ariaDescribedby"
                      name="radio-sub-component"
                    >
                      <b-form-radio
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="0"
                        >{{ $t("single_strategy") }}</b-form-radio
                      >
                      <b-form-radio
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="1"
                        >{{ $t("circular_strategy") }}</b-form-radio
                      >
                    </b-form-radio-group>
                  </b-form-group>

                  <b-row>
                    <b-col cols="6" class="pl-1 pr-3">
                      <b-button block type="submit" variant="primary">{{
                        $t("submit")
                      }}</b-button>
                    </b-col>
                    <b-col cols="6" class="pl-1 pr-3">
                      <b-button
                        block
                        type="button"
                        variant="outline-primary"
                        @click="backpage"
                      >
                        {{ $t("cancel") }}</b-button
                      >
                    </b-col></b-row
                  >
                </b-form>
              </b-card>
            </b-col>
          </b-row>
        </b-tab>
        <b-tab no-body :title="$t('conserve')" @click="conserve">
          <b-row align-h="center" @submit="postData">
            <b-col md="5" class="p-0">
              <b-card>
                <b-form>
                  <b-form-group
                    id="input-group-1"
                    :label="$t('gas')"
                    label-for="input-1"
                  >
                    <b-form-input
                      id="input-1"
                      v-model="balance"
                      type="text"
                      readonly
                      required
                    ></b-form-input>
                  </b-form-group>

                  <!-- <b-form-group
                id="input-group-2"
                :label="$t('gas')"
                label-for="input-2"
              >
                <b-form-input
                  id="input-2"
                  v-model="form.first_order_value"
                  type="number"
                  required
                ></b-form-input>
              </b-form-group> -->
                  <b-form-group
                    id="input-group-2"
                    :label="$t('first_buy_in_amount')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.first_order_value"
                      type="number"
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-row class="form-group" align-h="between">
                    <b-col cols="8">
                      <label for="first_order_double" class="col-form-label">{{
                        $t("first_order_double")
                      }}</label>
                    </b-col>
                    <b-col cols="4" class="py-2">
                      <label class="switch switch-primary mr-3">
                        <input
                          type="checkbox"
                          v-model="form.first_order_double"
                        />
                        <span class="slider"></span>
                      </label>
                    </b-col>
                  </b-row>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('numbers_of_cover_up')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.max_order_count"
                      type="number"
                      @change="setMarginConfig"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('take_profit_ratio')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.stop_profit_rate"
                      type="number"
                      required
                      step="any"
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('earnings_callback')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.stop_profit_callback_rate"
                      type="number"
                      step="any"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('margin_call_drop')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.cover_rate"
                      type="number"
                      @change="setMarginConfig"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-button
                    block
                    type="button"
                    class="form-control py-1 px-2 my-3"
                    @click="openModal()"
                    >{{ $t("margin_call_setting") }}
                  </b-button>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('buy_in_callback')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.cover_callback_rate"
                      type="number"
                      step="any"
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    :label="$t('strategy_type')"
                    v-slot="{ ariaDescribedby }"
                  >
                    <b-form-radio-group
                      id="radio-group-2"
                      v-model="form.recycle_status"
                      :aria-describedby="ariaDescribedby"
                      name="radio-sub-component"
                    >
                      <b-form-radio
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="0"
                        >{{ $t("single_strategy") }}</b-form-radio
                      >
                      <b-form-radio
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="1"
                        >{{ $t("circular_strategy") }}</b-form-radio
                      >
                    </b-form-radio-group>
                  </b-form-group>

                  <b-row>
                    <b-col cols="6" class="pl-1 pr-3">
                      <b-button block type="submit" variant="primary">{{
                        $t("submit")
                      }}</b-button>
                    </b-col>
                    <b-col cols="6" class="pl-1 pr-3">
                      <b-button
                        block
                        type="button"
                        variant="outline-primary"
                        @click="backpage"
                      >
                        {{ $t("cancel") }}</b-button
                      >
                    </b-col></b-row
                  >
                </b-form>
              </b-card>
            </b-col>
          </b-row>
        </b-tab>
        <b-tab no-body :title="$t('stable')" @click="stable">
          <b-row align-h="center" @submit="postData">
            <b-col md="5" class="p-0">
              <b-card>
                <b-form>
                  <b-form-group
                    id="input-group-1"
                    :label="$t('gas')"
                    label-for="input-1"
                  >
                    <b-form-input
                      id="input-1"
                      v-model="balance"
                      type="text"
                      readonly
                      required
                    ></b-form-input>
                  </b-form-group>

                  <!-- <b-form-group
                id="input-group-2"
                :label="$t('gas')"
                label-for="input-2"
              >
                <b-form-input
                  id="input-2"
                  v-model="form.first_order_value"
                  type="number"
                  required
                ></b-form-input>
              </b-form-group> -->
                  <b-form-group
                    id="input-group-2"
                    :label="$t('first_buy_in_amount')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.first_order_value"
                      type="number"
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-row class="form-group" align-h="between">
                    <b-col cols="8">
                      <label for="first_order_double" class="col-form-label">{{
                        $t("first_order_double")
                      }}</label>
                    </b-col>
                    <b-col cols="4" class="py-2">
                      <label class="switch switch-primary mr-3">
                        <input
                          type="checkbox"
                          v-model="form.first_order_double"
                        />
                        <span class="slider"></span>
                      </label>
                    </b-col>
                  </b-row>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('numbers_of_cover_up')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.max_order_count"
                      type="number"
                      @change="setMarginConfig"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('take_profit_ratio')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.stop_profit_rate"
                      type="number"
                      required
                      step="any"
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('earnings_callback')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.stop_profit_callback_rate"
                      type="number"
                      step="any"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('margin_call_drop')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.cover_rate"
                      type="number"
                      @change="setMarginConfig"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-button
                    block
                    type="button"
                    class="form-control py-1 px-2 my-3"
                    @click="openModal()"
                    >{{ $t("margin_call_setting") }}
                  </b-button>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('buy_in_callback')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.cover_callback_rate"
                      type="number"
                      step="any"
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    :label="$t('strategy_type')"
                    v-slot="{ ariaDescribedby }"
                  >
                    <b-form-radio-group
                      id="radio-group-2"
                      v-model="form.recycle_status"
                      :aria-describedby="ariaDescribedby"
                      name="radio-sub-component"
                    >
                      <b-form-radio
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="0"
                        >{{ $t("single_strategy") }}</b-form-radio
                      >
                      <b-form-radio
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="1"
                        >{{ $t("circular_strategy") }}</b-form-radio
                      >
                    </b-form-radio-group>
                  </b-form-group>

                  <b-row>
                    <b-col cols="6" class="pl-1 pr-3">
                      <b-button block type="submit" variant="primary">{{
                        $t("submit")
                      }}</b-button>
                    </b-col>
                    <b-col cols="6" class="pl-1 pr-3">
                      <b-button
                        block
                        type="button"
                        variant="outline-primary"
                        @click="backpage"
                      >
                        {{ $t("cancel") }}</b-button
                      >
                    </b-col></b-row
                  >
                </b-form>
              </b-card>
            </b-col>
          </b-row>
        </b-tab>
        <b-tab no-body :title="$t('customize')" @click="customize">
          <b-row align-h="center" @submit="postData">
            <b-col md="5" class="p-0">
              <b-card>
                <b-form>
                  <b-form-group
                    id="input-group-1"
                    :label="$t('gas')"
                    label-for="input-1"
                  >
                    <b-form-input
                      id="input-1"
                      v-model="balance"
                      type="text"
                      readonly
                      required
                    ></b-form-input>
                  </b-form-group>

                  <!-- <b-form-group
                id="input-group-2"
                :label="$t('gas')"
                label-for="input-2"
              >
                <b-form-input
                  id="input-2"
                  v-model="form.first_order_value"
                  type="number"
                  required
                ></b-form-input>
              </b-form-group> -->
                  <b-form-group
                    id="input-group-2"
                    :label="$t('first_buy_in_amount')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.first_order_value"
                      type="number"
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-row class="form-group" align-h="between">
                    <b-col cols="8">
                      <label for="first_order_double" class="col-form-label">{{
                        $t("first_order_double")
                      }}</label>
                    </b-col>
                    <b-col cols="4" class="py-2">
                      <label class="switch switch-primary mr-3">
                        <input
                          type="checkbox"
                          v-model="form.first_order_double"
                        />
                        <span class="slider"></span>
                      </label>
                    </b-col>
                  </b-row>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('numbers_of_cover_up')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.max_order_count"
                      type="number"
                      @change="setMarginConfig"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('take_profit_ratio')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.stop_profit_rate"
                      type="number"
                      required
                      step="any"
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('earnings_callback')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.stop_profit_callback_rate"
                      type="number"
                      step="any"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('margin_call_drop')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.cover_rate"
                      type="number"
                      @change="setMarginConfig"
                      required
                    ></b-form-input>
                  </b-form-group>
                  <b-button
                    block
                    type="button"
                    class="form-control py-1 px-2 my-3"
                    @click="openModal()"
                    >{{ $t("margin_call_setting") }}
                  </b-button>
                  <b-form-group
                    id="input-group-2"
                    :label="$t('buy_in_callback')"
                    label-for="input-2"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="form.cover_callback_rate"
                      type="number"
                      step="any"
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    :label="$t('strategy_type')"
                    v-slot="{ ariaDescribedby }"
                  >
                    <b-form-radio-group
                      id="radio-group-2"
                      v-model="form.recycle_status"
                      :aria-describedby="ariaDescribedby"
                      name="radio-sub-component"
                    >
                      <b-form-radio
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="0"
                        >{{ $t("single_strategy") }}</b-form-radio
                      >
                      <b-form-radio
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="1"
                        >{{ $t("circular_strategy") }}</b-form-radio
                      >
                    </b-form-radio-group>
                  </b-form-group>

                  <b-row>
                    <b-col cols="6" class="pl-1 pr-3">
                      <b-button block type="submit" variant="primary">{{
                        $t("submit")
                      }}</b-button>
                    </b-col>
                    <b-col cols="6" class="pl-1 pr-3">
                      <b-button
                        block
                        type="button"
                        variant="outline-primary"
                        @click="backpage"
                      >
                        {{ $t("cancel") }}</b-button
                      >
                    </b-col></b-row
                  >
                </b-form>
              </b-card>
            </b-col>
          </b-row>
        </b-tab>
      </b-tabs>
    </div>

    <b-modal
      id="modal-marginConfig"
      size="sm"
      centered
      :title="$t('margin_call_setting')"
      hide-footer
    >
      <b-form class="mx-4" v-on:submit.prevent="checkValue">
        <div class="form-group">
          <b-row>
            <b-col cols="6" class="px-1">
              <label class="col-form-label text-center">
                {{ $t("buyback_drop") }}
              </label>
            </b-col>
            <b-col cols="6" class="px-1">
              <label class="col-form-label text-center">
                {{ $t("buyback_ratios") }}
              </label>
            </b-col>
          </b-row>
          <b-row
            v-for="(item, index) in form.custom_cover.length"
            :key="item.id"
          >
            <b-col cols="12" class="px-1 pt-1">
              <span v-if="index == 0">{{ $t("buyback1") }}</span>
              <span v-else>{{ index + 1 }}{{ $t("buyback") }}</span>
            </b-col>
            <b-col cols="6" class="p-1">
              <input
                type="number"
                class="form-control"
                v-model="form.custom_cover[index]['percentage']"
                max="100"
                min="1"
                required
              />
            </b-col>
            <b-col cols="6" class="p-1">
              <input
                type="number"
                class="form-control"
                v-model="form.custom_cover[index]['times']"
                required
                min="1"
              />
            </b-col>
          </b-row>
        </div>

        <b-button block variant="primary" class="px-auto mt-1" type="submit">
          OK</b-button
        >
      </b-form>
    </b-modal>

    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import {
  getAccountInfo,
  getMemberInfo,
  createRobot,
  editRobot,
  getRobotInfo,
} from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import Dialog from "../../../components/dialog.vue";
import { mapGetters } from "vuex";
export default {
  props: ["items"],
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
  },
  data() {
    return {
      form: {
        gas_type: "point2",
        platform: "",
        robot_id: "",
        market_id: "",
        first_order_value: "100",
        max_order_count: "6",
        first_order_double: false,
        stop_profit_rate: "1.8",
        stop_profit_callback_rate: "0.3",
        cover_rate: "3",
        cover_callback_rate: "0.2",
        recycle_status: "0",
        custom_cover: [],
      },
      checkApiBinding: false,
      isLoading: false,
      robotInfo: null,
      infoDetail: null,
      marketName: "",
      pin: "",
      balance: "",
    };
  },
  methods: {
    backpage() {
      this.$router.go(-1)
    },
    checkValue() {
      this.$bvModal.hide("modal-marginConfig");
    },
    radical() {
      this.form.first_order_value = "100";
      this.form.max_order_count = "6";
      this.form.stop_profit_rate = "1.8";
      this.form.stop_profit_callback_rate = "0.3";
      this.form.cover_rate = "3";
      this.form.cover_callback_rate = "0.2";
      this.setMarginConfig();
    },
    conserve() {
      this.form.first_order_value = "100";
      this.form.max_order_count = "6";
      this.form.stop_profit_rate = "1.3";
      this.form.stop_profit_callback_rate = "0.3";
      this.form.cover_rate = "5";
      this.form.cover_callback_rate = "0.5";
      this.setMarginConfig();
    },
    stable() {
      this.form.first_order_value = "100";
      this.form.max_order_count = "6";
      this.form.stop_profit_rate = "1.5";
      this.form.stop_profit_callback_rate = "0.3";
      this.form.cover_rate = "4";
      this.form.cover_callback_rate = "0.3";
      this.setMarginConfig();
    },
    customize() {
      this.form.first_order_value = "";
      this.form.max_order_count = "";
      this.form.stop_profit_rate = "";
      this.form.stop_profit_callback_rate = "";
      this.form.cover_rate = "";
      this.form.cover_callback_rate = "";
      this.setMarginConfig();
    },
    openModal() {
      this.$bvModal.show("modal-marginConfig");
    },
    getInfo() {
      var result = getMemberInfo();
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          self.isLoading = false;
          self.pin = value.data.pin;
          self.balance = value.data.point2;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    setMarginConfig() {
      this.form.custom_cover = [];
      for (let i = 0; i < this.form.max_order_count; i++) {
        var tmap = {};
        tmap["percentage"] = this.form.cover_rate;
        tmap["times"] = 1;
        this.form.custom_cover.push(tmap);
      }
    },
    postData(e) {
      e.preventDefault();
      this.form.first_order_double = this.form.first_order_double ? 1 : 0;
      let formData = JSON.stringify(this.form);
      var result;
      var self = this;
      if (this.robotInfo == "" || this.robotInfo == null) {
        this.$delete(this.form, "robot_id");
        formData = JSON.stringify(this.form);
        result = createRobot(formData);
      } else {
        result = editRobot(formData);
      }
      this.isLoading = true;

      result
        .then(function (value) {
          if (value.data.code > 0) {
            self.$swal({
              icon: "error",
              text: self.$t(value.data.message),
            });
          } else {
            self
              .$swal({
                icon: "success",
                text: self.$t(value.data.message),
              })
              .then(() => {
                self.$router.replace({
                  path: "/quantitative/marketList",
                  // query: {
                  //   id: this.robotInfo == null ? "" : this.robotInfo.id,
                  //   market: this.$route.query.marketName,
                  //   market_id: this.$route.query.marketID,
                  //   platform: this.$route.query.platform,
                  // },
                });
              });
          }
          self.isLoading = false;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    getRobot() {
      this.robotID = this.$route.query.id;
      var result = getRobotInfo(this.robotID);
      var self = this;
      result
        .then(function (value) {
          self.robotInfo = value.data.data;
          self.isLoading = false;

          self.form.platform = self.$route.query.platform;
          self.form.market_id = self.$route.query.marketID;
          if (self.robotInfo != null) {
            self.form.robot_id = self.robotInfo.id;
            self.form.first_order_value = self.robotInfo.first_order_value;
            self.form.max_order_count = self.robotInfo.max_order_count;
            self.form.first_order_double =
              self.robotInfo.first_order_double == 1 ? true : false;
            self.form.stop_profit_rate = self.robotInfo.stop_profit_rate;
            self.form.stop_profit_callback_rate =
              self.robotInfo.stop_profit_callback_rate;
            self.form.cover_rate = self.robotInfo.cover_rate;
            self.form.cover_callback_rate = self.robotInfo.cover_callback_rate;
            self.form.cover_rate = self.robotInfo.cover_rate;
            self.form.recycle_status = self.robotInfo.recycle_status;
            if (self.robotInfo.custom_cover != null) {
              self.form.custom_cover = JSON.parse(self.robotInfo.custom_cover);
            } else {
              self.setMarginConfig();
            }
          } else {
            self.setMarginConfig();
          }
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
    loadItems() {
      let formData = new FormData();
      formData.append("platform", this.$route.query.platform);
      var result = getAccountInfo(formData);
      var self = this;
      this.isLoading = true;
      result
        .then(function (value) {
          if (value.data.code != 0) {
            self.checkApiBinding = true;
          }
          self.isLoading = false;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {
    this.getRobot();
    this.loadItems();
    this.getInfo();
  },
};
</script>