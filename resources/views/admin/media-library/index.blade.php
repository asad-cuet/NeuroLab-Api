@extends('admin.layouts.master')

@section('title')
    Media Library
@endsection
@section('container')

    <div class="trk-card">
        <div class="trk-card__header">
        <div class="trk-card__header-title">
            <h5>Media Library</h5>
        </div>
        <div class="trk-card__header-actions">
            <div class="form-group d-flex gap-2">
            <!-- <div class="form-group position-relative">
                <input type="text" class="form-control ps-5" placeholder="Search..." aria-label="Search">
                <i class="lni lni-search-alt position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
            </div> -->
            <div class="form-group search-item">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
                
                <i class="lni lni-search-alt"></i>
            </div>

            <div class="form-group"> 
                <select class="form-select search-select" name="status">
                <option value="">Sort By</option>
                <option value="option1">Option 1</option>
                <option value="option2">Option 2</option>
                <option value="option3">Option 3</option>
                <option value="option4">Option 4</option>
                </select>
            </div>
            </div>
        </div>
        </div>
        <div class="trk-card__body">

        <div class="media-library">
            <div class="row g-4 gx-lg-5">
            <div class="col-lg-8 border2-lg-end">
            <form action="/upload" class="media-library__upload-dropzone dropzone" id="media-dropzone">
                <label class="media-library__upload-label" for="file">Upload file<span>*</span></label>
                <div class="dz-message" id="file">
                    <p>Drag & Drop your files or <a href="#">Browse</a></p>
                </div>

                <div class="media-library__file-list mt-4"></div>
                
                <button class="btn btn-primary mt-3 mb-4" id="store-image-btn" style="display: none;">Store Image</button>
            </form>

                <ul class="media-library__list mt-4">
                <li class="media-library__item media-library__folder">
                    <a href="media-folder.html">
                    <div class="media-library__item-inner">
                        <div class="media-library__item-image">
                        <span class="trk-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <path
                                d="M3.33337 31.6667V12.5817C3.33337 10.1753 3.33337 8.97203 3.73891 8.02745C4.24454 6.84975 5.18312 5.91117 6.36082 5.40553C7.30541 5 8.49679 5 10.9151 5H11.7386C12.747 5 13.7013 5.45657 14.3341 6.24182L17.3625 10M17.3625 10H26.6667C29.0002 10 30.167 10 31.0584 10.4541C31.8424 10.8536 32.4797 11.491 32.8792 12.275C33.3334 13.1663 33.3334 14.3331 33.3334 16.6667V18.3333M17.3625 10H11.6667"
                                stroke="#6D71FA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M5.26341 25.8573L5.76076 24.6194C6.98386 21.5748 7.59542 20.0526 8.87071 19.1929C10.146 18.3333 11.7927 18.3333 15.086 18.3333H28.5199C33.0007 18.3333 35.241 18.3333 36.237 19.7978C37.2329 21.2624 36.4009 23.3336 34.7367 27.4759L34.2394 28.7138C33.0162 31.7584 32.4047 33.2806 31.1294 34.1403C29.854 34.9999 28.2074 34.9999 24.914 34.9999H11.4802C6.99939 34.9999 4.75896 34.9999 3.76307 33.5354C2.76719 32.0708 3.59926 29.9996 5.26341 25.8573Z"
                                stroke="#6D71FA" stroke-width="2" stroke-linejoin="round" />
                            </svg>
                        </span>
                        </div>
                        <div class="media-library__item-info">
                        <p>Folder</p>
                        <span>Folder is empty </span>
                        </div>
                    </div>
                    </a>
                </li>
                <li class="media-library__item">
                    <div class="media-library__item-inner">
                    <div class="media-library__item-image">
                        <img src="/assets/images/media/1.png" alt="Image C.jpg">
                    </div>
                    <div class="media-library__item-info">
                        <p>Image C.jpg</p>
                        <span>123.35 KB </span>
                    </div>
                    </div>
                </li>
                <li class="media-library__item">
                    <div class="media-library__item-inner">
                    <div class="media-library__item-image">
                        <img src="/assets/images/media/2.png" alt="Image C.jpg">
                    </div>
                    <div class="media-library__item-info">
                        <p>Image C.jpg</p>
                        <span>123.35 KB </span>
                    </div>
                    </div>
                </li>
                <li class="media-library__item">
                    <div class="media-library__item-inner">
                    <div class="media-library__item-image">
                        <img src="/assets/images/media/3.png" alt="Image C.jpg">
                    </div>
                    <div class="media-library__item-info">
                        <p>Image C.jpg</p>
                        <span>123.35 KB </span>
                    </div>
                    </div>
                </li>
                <li class="media-library__item active">
                    <div class="media-library__item-inner">
                    <div class="media-library__item-image">
                        <img src="/assets/images/media/9.png" alt="Image C.jpg">
                    </div>
                    <div class="media-library__item-info">
                        <p>Image C.jpg</p>
                        <span>123.35 KB </span>
                    </div>
                    </div>
                </li>
                <li class="media-library__item">
                    <div class="media-library__item-inner">
                    <div class="media-library__item-image">
                        <img src="/assets/images/media/4.png" alt="Image C.jpg">
                    </div>
                    <div class="media-library__item-info">
                        <p>Image C.jpg</p>
                        <span>123.35 KB </span>
                    </div>
                    </div>
                </li>
                <li class="media-library__item ">
                    <div class="media-library__item-inner">
                    <div class="media-library__item-image">
                        <img src="/assets/images/media/5.png" alt="Image C.jpg">
                    </div>
                    <div class="media-library__item-info">
                        <p>Image C.jpg</p>
                        <span>123.35 KB </span>
                    </div>
                    </div>
                </li>
                <li class="media-library__item">
                    <div class="media-library__item-inner">
                    <div class="media-library__item-image">
                        <img src="/assets/images/media/1.png" alt="Image C.jpg">
                    </div>
                    <div class="media-library__item-info">
                        <p>Image C.jpg</p>
                        <span>123.35 KB </span>
                    </div>
                    </div>
                </li>

                <li class="media-library__item">
                    <div class="media-library__item-inner">
                    <div class="media-library__item-image">
                        <img src="/assets/images/media/1.png" alt="Image C.jpg">
                    </div>
                    <div class="media-library__item-info">
                        <p>Image C.jpg</p>
                        <span>123.35 KB </span>
                    </div>
                    </div>
                </li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="media-library__info">
                <img src="/assets/images/media/9.png" alt="Image F.jpg" class="media-library__info-image">
                <h6 class="media-library__info-title">Image F.jpg</h6>
                <p class="media-library__info-size">45.94 KB</p>

                <div class="media-library__info-section"> 
                    <h6>Information</h6>
                    <ul class="media-library__info-details">
                    <li><span class="option">Uploaded by:</span> <span>Demo Users</span></li>
                    <li><span class="option">Uploaded at:</span> <span>Today at 4:40 PM</span></li>
                    <li><span class="option">Dimensions:</span> <span>1920 x 1280</span></li>
                    <li><span class="option">ID:</span> <span>6</span></li>
                    <li><span class="option">Thumb conversion generated:</span> <span>Yes</span></li>
                    </ul>
                </div>

                <div class="media-library__info-section media-library__info-edit">
                    <h6>Edit</h6>
                    <div class="item">
                    <p>Save additional information to this media item.</p>
                    <button class="border-0">
                        <span class="trk-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <g clip-path="url(#clip0_145_2034)">
                            <path d="M9.38239 2.59046C9.87919 2.05222 10.1276 1.7831 10.3915 1.62612C11.0284 1.24734 11.8127 1.23556 12.4602 1.59504C12.7285 1.74403 12.9845 2.00558 13.4966 2.52867C14.0087 3.05176 14.2647 3.31331 14.4105 3.58745C14.7625 4.24891 14.7509 5.05002 14.3801 5.70063C14.2265 5.97027 13.963 6.22402 13.4361 6.7315L7.16699 12.7697C6.16851 13.7314 5.66925 14.2123 5.04529 14.456C4.42133 14.6997 3.73539 14.6818 2.36349 14.6459L2.17684 14.641C1.75919 14.6301 1.55037 14.6246 1.42898 14.4868C1.30759 14.3491 1.32416 14.1364 1.35731 13.711L1.37531 13.48C1.46859 12.2825 1.51523 11.6838 1.74906 11.1456C1.98288 10.6074 2.38621 10.1705 3.19287 9.2965L9.38239 2.59046Z" stroke="#7B829D" stroke-linejoin="round"/>
                            <path d="M8.66675 2.66699L13.3334 7.33366" stroke="#7B829D" stroke-linejoin="round"/>
                            <path d="M9.33325 14.667H14.6666" stroke="#7B829D" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_145_2034">
                                <rect width="16" height="16" fill="white"/>
                            </clipPath>
                            </defs>
                        </svg>
                        </span>
                    </button>
                    </div>
                </div>

                <div class="media-library__info-section media-library__info-move">
                    <h6>Move media to</h6>
                    <div class="item">
                    <p>Currently in root folder</p>
                    <button class="border-0">
                        <span class="trk-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <g clip-path="url(#clip0_145_2034)">
                            <path d="M9.38239 2.59046C9.87919 2.05222 10.1276 1.7831 10.3915 1.62612C11.0284 1.24734 11.8127 1.23556 12.4602 1.59504C12.7285 1.74403 12.9845 2.00558 13.4966 2.52867C14.0087 3.05176 14.2647 3.31331 14.4105 3.58745C14.7625 4.24891 14.7509 5.05002 14.3801 5.70063C14.2265 5.97027 13.963 6.22402 13.4361 6.7315L7.16699 12.7697C6.16851 13.7314 5.66925 14.2123 5.04529 14.456C4.42133 14.6997 3.73539 14.6818 2.36349 14.6459L2.17684 14.641C1.75919 14.6301 1.55037 14.6246 1.42898 14.4868C1.30759 14.3491 1.32416 14.1364 1.35731 13.711L1.37531 13.48C1.46859 12.2825 1.51523 11.6838 1.74906 11.1456C1.98288 10.6074 2.38621 10.1705 3.19287 9.2965L9.38239 2.59046Z" stroke="#7B829D" stroke-linejoin="round"/>
                            <path d="M8.66675 2.66699L13.3334 7.33366" stroke="#7B829D" stroke-linejoin="round"/>
                            <path d="M9.33325 14.667H14.6666" stroke="#7B829D" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_145_2034">
                                <rect width="16" height="16" fill="white"/>
                            </clipPath>
                            </defs>
                        </svg>
                        </span>
                    </button>
                    </div>
                </div>

                <div class="media-library__info-actions d-flex flex-grow-1 gap-3 mt-4">
                    <button class="btn btn-primary flex-grow-1">View</button>
                    <button class="btn btn-light3 flex-grow-1">Delete</button>
                </div>


                </div>

                <!-- if not select any item show this -->
                <!-- <div class="media-library__status">
                <h6 class="fw-medium fs-5 text-black">Select Image</h6>
                <p class="text-muted fw-medium mb-0">Select a file to view its information</p>
                </div> -->

            </div>
            </div>
        </div>

        </div>
    </div>

@endsection

@section('css')

@endsection
@section('js')
    @parent
    {{--SCRIPT--}}

@endsection
