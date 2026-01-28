import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";

registerBlockType("aletho/contactform", {
	edit: Edit,
});
