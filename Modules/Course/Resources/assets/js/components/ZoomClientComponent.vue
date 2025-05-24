<template>
  <main>
    <!-- For Component View -->
    <div id="meetingSDKElement">
      <!-- Zoom Meeting SDK Component View Rendered Here -->
    </div>
  </main>
</template>

<script>
import axios from "axios";
import ZoomMtgEmbedded from "@zoomus/websdk/embedded";

export default {
  name: "ZoomClientComponent",
  props: {
    urlSignature: {
      type: String,
      required: true,
    },
    meetingNumber: {
      default: "212321",
    },
    userEmail: {
      type: String,
      default: "",
    },
    userName: {
      type: String,
      default: "vue",
    },
    role: {
      type: String,
      default: "1",
    },
    passWord: {
      type: String,
      default: "12345678",
    },
  },
  created() {
    this.getSignature();
  },
  data() {
    return {
      client: ZoomMtgEmbedded.createClient(),
      // This Sample App has been updated to use SDK App type credentials https://marketplace.zoom.us/docs/guides/build/sdk-app
      apiKey: "tVz3a_z6SryzcPAdky6_vw",
      // pass in the registrant's token if your meeting or webinar requires registration. More info here:
      // Meetings: https://marketplace.zoom.us/docs/sdk/native-sdks/web/component-view/meetings#join-registered
      // Webinars: https://marketplace.zoom.us/docs/sdk/native-sdks/web/component-view/webinars#join-registered
      registrantToken: "",
    };
  },
  methods: {
    getSignature() {
      axios
        .post(this.urlSignature, {
          meetingNumber: this.meetingNumber,
          role: this.role,
        })
        .then((res) => {
          console.log(res.data.signature);
          this.startMeeting(res.data.signature);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    startMeeting(signature) {
      let meetingSDKElement = document.getElementById("meetingSDKElement");

      this.client.init({
        debug: false,
        zoomAppRoot: meetingSDKElement,
        language: "en-US",
        customize: {
          meetingInfo: [
            "topic",
            "host",
            "mn",
            "pwd",
            "telPwd",
            "invite",
            "participant",
            "dc",
            "enctype",
          ],
          toolbar: {
            buttons: [
              {
                text: "Custom Button",
                className: "CustomButton",
                onClick: () => {
                  console.log("custom button");
                },
              },
            ],
          },
        },
      });

      this.client.join({
        apiKey: this.apiKey,
        signature: signature,
        meetingNumber: this.meetingNumber,
        password: this.passWord,
        userName: this.userName,
        userEmail: this.userEmail,
        tk: this.registrantToken,
      });
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
main {
  width: 100%;
  margin: auto;
  text-align: center;
}

main button {
  margin-top: 20px;
  background-color: #2d8cff;
  color: #ffffff;
  text-decoration: none;
  padding-top: 10px;
  padding-bottom: 10px;
  padding-left: 40px;
  padding-right: 40px;
  display: inline-block;
  border-radius: 10px;
  cursor: pointer;
  border: none;
  outline: none;
}

main button:hover {
  background-color: #2681f2;
}
</style>
