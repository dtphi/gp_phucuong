import Vue from 'vue'
const GlobalEvent = new Vue()
export const EventBus = GlobalEvent
export const EmitOnSelectedImage = (params) => {
  GlobalEvent.$emit('on-selected-image', params)
}
export const OnSelectedImage = (params) => {
  GlobalEvent.$on('on-selected-image', params)
}
export const EmitOnSelectInfoMediaImg = (params) => {
  GlobalEvent.$emit('select-info-media-img', params)
}