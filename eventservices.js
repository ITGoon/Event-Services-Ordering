
// Shows the unlisted event details boxes if necessary

function showUnlisted(selBox, detailBoxId) {
  if (selBox.options[selBox.selectedIndex].value == 9) {
    if (!Element.visible(detailBoxId)) {
      new Effect.SlideDown(detailBoxId, { duration: 1.0});
    }
    //Element.show(detailBoxId);
  } else {
    if (Element.visible(detailBoxId)) {
      new Effect.SlideUp(detailBoxId, { duration: 1.0});
    } 
      //afterFinish: function {Element.hide(detailBoxId);}});
    //Element.hide(detailBoxId);
  }
}
